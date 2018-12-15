<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\GroupSupplier;
use App\Models\PCategory;

class CategoryController extends Controller
{
    public $_pcategory_ids = [];

    public function __construct()
    {
        $this->_pcategory_ids = PCategory::select('parent_id')
            ->whereNotNull('parent_id')
            ->pluck('parent_id')
            ->toArray();
    }
    //
    public function getCategory(Request $request)
    {
        $s_ids = GroupSupplier::where('group_id',$request->group_id)->pluck('supplier_id')->toArray();

        $product_node = DB::table('products as p')
            ->select('p.id', 'pc.pcategory_id', 'pp.name AS pc_name', 'p2.id AS p2_id', 'p2.name AS p2_name', 'p3.id AS p3_id', 'p3.name AS p3_name', 'p4.id AS p4_id', 'p4.name AS p4_name', 'p4.parent_id', 'pp.name as cname', 'p.supplier_id', 'p.name', 'p.images', 'p.barcode_image', 'p.items_per_outer', 'p.rrp', 'p.barcode_unit', DB::raw("CONCAT(IFNULL(LPAD(p3.parent_id,5,'0'), '00000'), '.', IFNULL(LPAD(p2.parent_id,5,'0'), '00000'), '.', LPAD(pp.parent_id,5,'0'), '.', LPAD(pp.id,5,'0'), '.', p.name) AS path"))
            ->join("product_category AS pc", "pc.product_id", "=", "p.id")
            ->leftJoin("pcategories AS pp", "pp.id", "=", "pc.pcategory_id")
            ->leftJoin("pcategories AS p2", "p2.id", "=", "pp.parent_id")
            ->leftJoin("pcategories AS p3", "p3.id", "=", "p2.parent_id")
            ->leftJoin("pcategories AS p4", "p4.id", "=", "p3.parent_id")
            ->whereIn('p.supplier_id', $s_ids)
            ->WhereNotNull('pc.pcategory_id')
            ->orderBy('pc.pcategory_id')
            ->orderBy('path')
            ->orderBy('p.name')
            ->get();

        $category_ids = array();
        $category_data = array();
        foreach ($product_node as $row) {
            $category_id = "c".$row->pcategory_id;
            if (!in_array($category_id, $category_ids)) {
                array_push($category_ids, $category_id);
                $cRow = array(
                    'id' => $category_id,
                    'name' => $row->pc_name,
                    'hasChild'=> 1
                );
                if ($row->p2_id) {
                    $p_id = "c".$row->p2_id;
                    $cRow = array_merge($cRow, array('pid' => $p_id));
                }
                array_push($category_data, $cRow);
            }

            if ($row->p2_id) {
                $category_id = "c".$row->p2_id;
                if (!in_array($category_id, $category_ids)) {
                    array_push($category_ids, $category_id);
                    $cRow = array(
                        'id' => $category_id,
                        'name' => $row->p2_name,
                        'hasChild'=> 1
                    );
                    if ($row->p3_id) {
                        $p_id = "c".$row->p3_id;
                        $cRow = array_merge($cRow, array('pid' => $p_id));
                    }
                    array_push($category_data, $cRow);
                }
            }

            if ($row->p3_id) {
                $category_id = "c".$row->p3_id;
                if (!in_array($category_id, $category_ids)) {
                    array_push($category_ids, $category_id);
                    $cRow = array(
                        'id' => $category_id,
                        'name' => $row->p3_name,
                        'hasChild'=> 1
                    );
                    if ($row->p4_id) {
                        $p_id = "c".$row->p4_id;
                        $cRow = array_merge($cRow, array('pid' => $p_id));
                    }
                    array_push($category_data, $cRow);
                }
            }

            if ($row->p4_id) {
                $category_id = "c".$row->p4_id;
                if (!in_array($category_id, $category_ids)) {
                    array_push($category_ids, $category_id);
                    $cRow = array(
                        'id' => $category_id,
                        'name' => $row->p4_name,
                        'hasChild'=> 1
                    );
                    if ($row->parent_id) {
                        $p_id = "c".$row->parent_id;
                        $cRow = array_merge($cRow, array('pid' => $p_id));
                    }
                    array_push($category_data, $cRow);
                }
            }
            if (!in_array($row->pcategory_id, $this->_pcategory_ids)) {
                $image_path = $row->images;
                if ($image_path) {
                    $image_path = json_decode($image_path);
                    $image_path = $image_path[0];
                }
                $ppRow = array(
                    'id' => "c" . $row->pcategory_id . "-p" . $row->id,
                    'pid' => "c" . $row->pcategory_id,
                    'name' => $row->name,
                    'images' => $image_path,
                    'items_per_outer' => $row->items_per_outer,
                    'rrp' => $row->rrp,
                    'barcode_unit' => $row->barcode_unit,
                    'barcode_image' => $row->barcode_image,
                    'product_is_new' => 0,
                );
                array_push($category_data, $ppRow);
            }
        }
        $category_data = array_filter($category_data);
        return $category_data;
    }
}
