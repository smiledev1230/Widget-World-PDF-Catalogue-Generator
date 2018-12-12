<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\PCategory;

class SupplierController extends Controller
{
    public $categories, $category_ids;
    public $suppliers, $supplier_ids;
    public $_pcategory_ids = [];

    public function __construct()
    {
        $this->_pcategory_ids = PCategory::select('parent_id')
            ->whereNotNull('parent_id')
            ->pluck('parent_id')
            ->toArray();
    }

    //
    public function getSupplier()
    {
        // Get category data of all product
        $product_node = DB::table('product_category AS pc')
            ->select('p.id', 'pc.pcategory_id', 'pp.name AS pc_name', 'p2.id AS p2_id', 'p2.name AS p2_name', 'p3.id AS p3_id', 'p3.name AS p3_name', 'p4.id AS p4_id', 'p4.name AS p4_name', 'p4.parent_id', 's.name as sname', 's.logo as brand_logo', 'pp.name as cname', 'p.supplier_id', 'p.name', 'p.images', 'p.barcode_image', 'p.items_per_outer', 'p.rrp', 'p.barcode_unit', DB::raw("CONCAT(IFNULL(LPAD(p3.parent_id,5,'0'), '00000'), '.', IFNULL(LPAD(p2.parent_id,5,'0'), '00000'), '.', LPAD(pp.parent_id,5,'0'), '.', LPAD(pp.id,5,'0'), '.', p.name) AS path"))
            ->join("products as p", "p.id", "=", "pc.product_id")
            ->leftJoin("pcategories AS pp", "pp.id", "=", "pc.pcategory_id")
            ->leftJoin("pcategories AS p2", "p2.id", "=", "pp.parent_id")
            ->leftJoin("pcategories AS p3", "p3.id", "=", "p2.parent_id")
            ->leftJoin("pcategories AS p4", "p4.id", "=", "p3.parent_id")
            ->leftJoin("suppliers AS s", "s.id", "=", "p.supplier_id")
            ->whereNotNull('p.supplier_id')
            ->WhereNotNull('pc.pcategory_id')
            ->orderBy('s.name')
            ->orderBy('pc.pcategory_id')
            ->orderBy('path')
            ->orderBy('p.name')
            ->get();

        $this->categories = $this->category_ids = array();
        $this->suppliers = $this->supplier_ids = array();
        $supplier_data = array();
        foreach ($product_node as $row) {
            $supplier_id = "s".$row->supplier_id;
            if (!in_array($supplier_id, $this->supplier_ids)) {
                array_push($this->supplier_ids, $supplier_id);
                $sRow = array(
                    'id' => $supplier_id,
                    'name' => $row->sname,
                    'brandLogo' => $row->brand_logo,
                    'hasChild' => 1,
                );
                array_push($supplier_data, $sRow);
            }

            $category_id = "s".$row->supplier_id."-c".$row->pcategory_id;
            if (!in_array($category_id, $this->category_ids)) {
                array_push($this->category_ids, $category_id);
                $p_id = $row->p2_id ? "s".$row->supplier_id."-c".$row->p2_id : $supplier_id;
                $cRow = array(
                    'id' => $category_id,
                    'name' => $row->pc_name,
                    'pid' => $p_id,
                    'hasChild'=> 1
                );
                array_push($supplier_data, $cRow);
            }

            if ($row->p2_id) {
                $category_id = "s".$row->supplier_id."-c".$row->p2_id;
                if (!in_array($category_id, $this->category_ids)) {
                    array_push($this->category_ids, $category_id);
                    $p_id = $row->p3_id ? "s".$row->supplier_id."-c".$row->p3_id : $supplier_id;
                    $cRow = array(
                        'id' => $category_id,
                        'name' => $row->p2_name,
                        'pid' => $p_id,
                        'hasChild'=> 1
                    );
                    array_push($supplier_data, $cRow);
                }
            }

            if ($row->p3_id) {
                $category_id = "s".$row->supplier_id."-c".$row->p3_id;
                if (!in_array($category_id, $this->category_ids)) {
                    array_push($this->category_ids, $category_id);
                    $p_id = $row->p4_id ? "s".$row->supplier_id."-c".$row->p4_id : $supplier_id;
                    $cRow = array(
                        'id' => $category_id,
                        'name' => $row->p3_name,
                        'pid' => $p_id,
                        'hasChild'=> 1
                    );
                    array_push($supplier_data, $cRow);
                }
            }

            if ($row->p4_id) {
                $category_id = "s".$row->supplier_id."-c".$row->p4_id;
                if (!in_array($category_id, $this->category_ids)) {
                    array_push($this->category_ids, $category_id);
                    $p_id = $row->parent_id ? "s".$row->supplier_id."-c".$row->parent_id : $supplier_id;
                    $cRow = array(
                        'id' => $category_id,
                        'name' => $row->p4_name,
                        'pid' => $p_id,
                        'hasChild'=> 1
                    );
                    array_push($supplier_data, $cRow);
                }
            }

            if (!in_array($row->pcategory_id, $this->_pcategory_ids)) {
                $image_path = $row->images;
                if ($image_path) {
                    $image_path = json_decode($image_path);
                    $image_path = $image_path[0];
                }
                $ppRow = array(
                    'id' => "s" . $row->supplier_id . "-c" . $row->pcategory_id . "-p" . $row->id,
                    'pid' => "s" . $row->supplier_id . "-c" . $row->pcategory_id,
                    'name' => $row->name,
                    'images' => $image_path,
                    'items_per_outer' => $row->items_per_outer,
                    'rrp' => $row->rrp,
                    'barcode_unit' => $row->barcode_unit,
                    'barcode_image' => $row->barcode_image,
                    'product_is_new' => 0,
                );
                array_push($supplier_data, $ppRow);
            }
        }
        $supplier_data = array_filter($supplier_data);
        return $supplier_data;
    }
}
