<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;

class SupplierController extends Controller
{
    //
    public function getSupplier() {
        $suppliers = Supplier::select('id','name')->get()->toArray();
        return $suppliers;
    }
}
