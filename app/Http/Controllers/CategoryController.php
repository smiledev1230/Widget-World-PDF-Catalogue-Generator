<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\PCategory;

class CategoryController extends Controller
{
    public $product_ids;
    //
    public function getCategory()
    {
        $category_nodes = PCategory::All()->map(function ($row) {
            $pRow = array(
                'id'=> 'c'.$row->id,
                'name'=> $row->name,
                'hasChild'=> 1
            );
            if ($row->parent_id) $pRow['pid'] = 'c'.$row->parent_id;
            return $pRow;
        })->toArray();

        $parent_ids = PCategory::select('parent_id')
            ->whereNotNull('parent_id')
            ->groupBy('parent_id');
        $product_node = DB::table('pcategories AS p')
            ->select('pro.id','pro.name', 'pc.pcategory_id', 'pro.images', 'pro.items_per_outer', 'pro.rrp', 'pro.barcode_unit', 'pro.barcode_image', DB::raw("CONCAT(IFNULL(LPAD(pp.parent_id,5,'0'), '00000'), '.', LPAD(p.parent_id,5,'0'), '.', LPAD(p.id,5,'0'), '.', pc.product_id) AS path"))
            ->leftJoin('pcategories AS pp', 'pp.id', '=', 'p.parent_id')
            ->join('product_category AS pc', 'p.id', '=', 'pc.pcategory_id')
            ->join('products AS pro', 'pc.product_id', '=', 'pro.id')
            ->whereNotIn('pc.pcategory_id', $parent_ids)
            ->get();

        $product_nodes = $product_node->map(function ($row) {
            $image_path = $row->images;
            if ($image_path) {
                $image_path = json_decode($image_path);
                $image_path = $image_path[0];
            }
            $ppRow = array(
                'id'=> 'c'.$row->pcategory_id.'-p'.$row->id,
                'name'=> $row->name,
                'images'=> $image_path,
                'items_per_outer'=> $row->items_per_outer,
                'rrp'=> $row->rrp,
                'barcode_unit'=> $row->barcode_unit,
                'barcode_image'=> $row->barcode_image,
                'product_is_new'=> 0,
            );
            if ($row->pcategory_id) $ppRow['pid'] = 'c'.$row->pcategory_id;
            return $ppRow;
        })->toArray();

        $categories = array_merge($category_nodes, $product_nodes);
        return $categories;
    }
}
