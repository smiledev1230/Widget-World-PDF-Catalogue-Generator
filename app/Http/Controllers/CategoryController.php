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
            ->select('p.id','p.name', 'pc.pcategory_id', 'p.images', 'p.items_per_outer', 'p.rrp', 'p.barcode_unit')
            ->join("products AS p", "p.id", "=", "pc.product_id")
            ->whereNotIn("pc.pcategory_id", $parent_ids)
            ->get();
        $this->product_ids = array();
        $product_list = $product_node->map(function ($row) {
            if (!in_array($row->id, $this->product_ids)) {
                array_push($this->product_ids, $row->id);
                $image_path = $row->images;
                if ($image_path) {
                    $image_path = json_decode($image_path);
                    $image_path = $image_path[0];
                }
                $ppRow = array(
                    'id'=> $row->id,
                    'name'=> $row->name,
                    'images'=> $image_path,
                    'items_per_outer'=> $row->items_per_outer,
                    'rrp'=> $row->rrp,
                    'barcode_unit'=> $row->barcode_unit,
                    'product_is_new'=> 0,
                    'product'=> 1,
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
