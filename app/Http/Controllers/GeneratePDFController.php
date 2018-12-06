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
}
