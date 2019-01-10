<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;

use App\Models\CatalogueCover;

class CoverController extends Controller
{
    public $_dir = "conversions/";

    public function getCovers(Request $request) {
        if ($request->id) {
            $cover = CatalogueCover::find($request->id);
            if ($cover) {
                return response()->json($cover->cover_url);
            } else {
                return response('');
            }
        } else {
            return response()->json(CatalogueCover::get());
        }
    }

    public function addCover(Request $request) {
        $params = $request->all();
        $uploadFile = $params['file'];
        $fileContent = file_get_contents($uploadFile);
        $filePath = $this->_dir.uniqid().'_'.$params['file_name'];
        Storage::disk('s3')->put($filePath, $fileContent, 'public');
        $s3SavedPath = Storage::disk('s3')->url($filePath);
        if ($s3SavedPath) {
            $cover = CatalogueCover::create(array('cover_url' => $s3SavedPath));
            return response()->json($cover);
        } else {
            return response()->json(['message' => 'failure']);
        }
    }

    public function deleteCover(Request $request) {
        $cover = CatalogueCover::find($request->id);
        if (isset($cover)) {
            $cover->delete();
            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['message' => 'failure']);
        }
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
}
