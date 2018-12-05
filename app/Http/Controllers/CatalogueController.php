<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Filesystem\FilesystemAdapter;

use Auth;
use App\Models\Catalogue;
use App\Models\EmailContent;
use App\Models\CatalogueSent;

class CatalogueController extends Controller
{
    public function getRecentCatalogue(Request $request)
    {
        $params = $request->all();
        if ($params && $params['limited']) {
            $recent_catalogue = DB::table('catalogue_pdf as p')
                ->select('p.*', DB::raw('DATE_FORMAT(p.updated_at, "%d/%m/%Y") as pdf_date'), DB::raw('GROUP_CONCAT(s.emails SEPARATOR ",") as emails'), DB::raw('GROUP_CONCAT(DATE_FORMAT(s.created_at, "%d/%m/%Y") SEPARATOR ",") as sent_date'))
                ->leftJoin("catalogue_sent AS s", "p.id", "=", "s.pdf_id")
                ->groupBy('p.id')
                ->orderBy('p.updated_at','desc')
                ->limit($params['limited'])
                ->get();
        } else {
            $recent_catalogue = DB::table('catalogue_pdf as p')
                ->select('p.*', DB::raw('DATE_FORMAT(p.updated_at, "%d/%m/%Y") as pdf_date'), DB::raw('GROUP_CONCAT(s.emails SEPARATOR ",") as emails'), DB::raw('GROUP_CONCAT(DATE_FORMAT(s.created_at, "%d/%m/%Y") SEPARATOR ",") as sent_date'))
                ->leftJoin("catalogue_sent AS s", "p.id", "=", "s.pdf_id")
                ->groupBy('p.id')
                ->orderBy('p.updated_at','desc')
                ->get();
        }
        $result = $recent_catalogue->map(function ($row) {
            if ($row->sent_date) $row->sent_date = explode(',', $row->sent_date);
            if ($row->emails) $row->emails = explode(',', $row->emails);
            if ($row->suppliers) $row->suppliers = explode(',', unserialize($row->suppliers));
            if ($row->categories) $row->categories = explode(',', unserialize($row->categories));
            if ($row->display_options) $row->display_options = explode(',', $row->display_options);
            if ($row->product_new) $row->product_new = explode(',', $row->product_new);
            if ($row->blocks) $row->blocks = json_decode($row->blocks);
            if ($row->drag_supplier_ids) $row->drag_supplier_ids = explode(',', $row->drag_supplier_ids);
            if ($row->drag_category_ids) $row->drag_category_ids = explode(',', $row->drag_category_ids);
            return $row;
        });
        return response()->json($result);
    }

    public function uploadToS3(Request $request)
    {
        $params = $request->all();
        $uploadFile = $params['file'];
        $fileContent = file_get_contents($uploadFile);
        $fileName = uniqid().'_'.$params['file_name'];
        $filePath = 'conversions/'.$fileName;
        Storage::disk('s3')->put($filePath, $fileContent, 'public');
        $s3SavedPath = Storage::disk('s3')->url($filePath);
        return response()->json($s3SavedPath);
    }

    public function saveSelectProduct(Request $request)
    {
        $params = $request->all();
        if (!$params['name'] || $params['name'] == 'null') return response('false');
        if ($params['suppliers']) $params['suppliers'] = serialize($params['suppliers']);
        if ($params['categories']) $params['categories'] = serialize($params['categories']);
        if (isset($params['id']) && !empty($params['id'])){
            $catalogue = Catalogue::find($params['id'])->fill($params)->update();
        } else {
            $catalogue = Catalogue::create($params);
        }
        return response()->json($catalogue);
    }

    public function duplicateCatalogue(Request $request)
    {
        $params = $request->all();
        $id = $params['id'];
        $name = $params['name'];
        $cat = Catalogue::find($id);
        $cat->name = $name;
        $cat->state = 1;
        $newCat = $cat->replicate();
        $newId = $newCat->save();
        $result = 'error';
        if ($newId) {
            $result = $this->getRecentCatalogue($request);
        }
        return $result;
    }

    public function deleteCatalogue(Request $request)
    {
        $id = $request->all('id');
        Catalogue::where('id', $id)->delete();
        return $this->getRecentCatalogue($request);
    }

    public function sendPDF(Request $request)
    {
        $params = $request->all();
        $pdf_path = $params['pdf_path'];
        $pdf_name = $params['name'].'.pdf';
        $to = explode(';', $params['emails']);
        $subject = $params['subject'];
        $emailContent = new EmailContent();
        $emailContent->notes = $params['notes'];
        Mail::send('email', ['emailContent' => $emailContent], function ($message) use ($to, $subject, $pdf_name, $pdf_path) {
            if (Storage::disk('s3')->exists($pdf_path)) {
                $pdfFile = Storage::disk('s3')->get($pdf_path);
                $message->attachData($pdfFile, $pdf_name);
            }
            $message->from(env('ORDER_FROM_EMAIL', 'info@brandzonline.com.au'), env('ORDER_FROM_NAME', 'Info'))->to($to)->subject($subject);
        });
        if (Mail::failures()) {
            return 'error';
        } else {
            Catalogue::find($request->id)->fill(array('state' => '2'))->update();
            CatalogueSent::create(array('pdf_id' => $request->id, 'emails' => implode('; ', $to)));
            return $this->getRecentCatalogue($request);
        }
    }
}
