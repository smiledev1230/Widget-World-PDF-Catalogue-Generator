<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PDF;

class GeneratePDFController extends Controller
{
    public $_dir = "conversions/";
    //
    public function savePDF(Request $request){
        $params = $request->all();
        $fileName = $params['fileName'];
        $filePath = $this->_dir.uniqid().'_'.$fileName.'.pdf';

        $productData = $params['productData'];
        $page_columns = $params['page_columns'];
        $display_options = $params['display_options'];
        $barcode_options = $params['barcode_options'];
        $pages = $params['pages'];
//        return view('pdf', compact('productData','page_columns', 'display_options', 'barcode_options', 'pages', 'fileName'));
        $pdf = PDF::loadView('pdf', compact('productData','page_columns', 'display_options', 'barcode_options', 'pages', 'fileName'));
//        $pdf->save($fileName.'.pdf');return 'ok';
        Storage::disk('s3')->put($filePath, $pdf->output(), 'public');
        return response()->json($filePath);
    }
}
