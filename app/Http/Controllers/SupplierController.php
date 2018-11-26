<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Supplier;

class SupplierController extends Controller
{
    //
    public function getSupplier() {
        $suppliers = Supplier::select('id','name',DB::raw('"false" as isChecked'))->get()->toArray();
        return $suppliers;
    }
}
