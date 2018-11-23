<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\PCategory;

class CategoryController extends Controller
{
    //
    public function getCategory() {
        $first = PCategory::select('id','parent_id as pid','name', DB::raw('true as hasChild'))
            ->whereNotNull('parent_id');
        $categories = PCategory::select('id',DB::raw('0 as pid'),'name', DB::raw('true as hasChild'))
            ->whereNull('parent_id')
            ->union($first)
            ->get()
            ->toArray();
        $root = '{
            "id": 0,
            "name": "All",
            "hasChild": true
        }';
        array_push($categories, json_decode($root, true));
        return $categories;
    }
}
