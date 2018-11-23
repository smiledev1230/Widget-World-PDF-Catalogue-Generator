<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\PCategory;

class CategoryController extends Controller
{
    public $product_ids;
    //
    public function getCategory() {
        $parent_ids = PCategory::select('parent_id')
            ->whereNotNull('parent_id');
        $parent_node = PCategory::select('id','name', 'parent_id')
            ->whereIn('id', $parent_ids)
            ->get();
        $parent_categories = $parent_node->map(function ($row) {
            $pRow = array(
                'id'=> $row->id,
                'name'=> $row->name,
                'hasChild'=> 1
            );
            if ($row->parent_id) $pRow['pid'] = $row->parent_id;
            return $pRow;
        })->toArray();

        $child_categories = PCategory::select('id','name', 'parent_id as pid', DB::raw('true as hasChild'))
            ->whereNotIn('id', $parent_ids)
            ->get()
            ->toArray();

        $product_node = DB::table('product_category as pc')
            ->select('p.id','p.name', 'pc.pcategory_id')
            ->join("products AS p", "p.id", "=", "pc.product_id")
            ->whereNotIn("pc.pcategory_id", $parent_ids)
            ->get();
        $this->product_ids = array();
        $product_list = $product_node->map(function ($row) {
            if (!in_array($row->id, $this->product_ids)) {
                array_push($this->product_ids, $row->id);
                $ppRow = array(
                    'id'=> $row->id,
                    'name'=> $row->name
                );
                if ($row->pcategory_id) $ppRow['pid'] = $row->pcategory_id;
                return $ppRow;
            }
        })->toArray();
        $product_categories = array_filter($product_list);
        $categories = array_merge($parent_categories, $child_categories, $product_categories);
        return $categories;
    }
}
