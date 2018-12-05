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
            ->select('p.id', 'pc.pcategory_id', 'pp.parent_id','s.name as sname', 'pp.name as cname', 'p.supplier_id', 'p.name', 'p.images', 'p.items_per_outer', 'p.rrp', 'p.barcode_unit')
            ->join("products as p", "p.id", "=", "pc.product_id")
            ->leftJoin("pcategories AS pp", "pp.id", "=", "pc.pcategory_id")
            ->leftJoin("suppliers AS s", "s.id", "=", "p.supplier_id")
            ->whereNotNull('p.supplier_id')
            ->WhereNotNull('pc.pcategory_id')
            ->get();
        $this->categories = $this->category_ids = array();
        $this->suppliers = $this->supplier_ids = array();

        $product_list = $product_node->map(function ($row) {
            $supplier_id = "s".$row->supplier_id;
            if (!in_array($supplier_id, $this->supplier_ids)) {
                array_push($this->supplier_ids, $supplier_id);
                $sRow = array(
                    'id' => $supplier_id,
                    'name' => $row->sname,
                    'hasChild' => 1,
                    'expanded' => 1
                );
                array_push($this->suppliers, $sRow);
            }

            $category_id = "s".$row->supplier_id."-c".$row->pcategory_id;
            if (!in_array($category_id, $this->category_ids)) {
                array_push($this->category_ids, $category_id);
                $p_id = $row->parent_id ? "s".$row->supplier_id."-c".$row->parent_id : $supplier_id;
                $cRow = array(
                    'id' => $category_id,
                    'name' => $row->cname,
                    'pid' => $p_id,
                    'hasChild'=> 1
                );
                array_push($this->categories, $cRow);
            }

            $image_path = $row->images;
            if ($image_path) {
                $image_path = json_decode($image_path);
                $image_path = $image_path[0];
            }
            if (!in_array($row->pcategory_id, $this->_pcategory_ids)) {
                $ppRow = array(
                    'id'=> "s".$row->supplier_id."-c".$row->pcategory_id."-p".$row->id,
                    'pid'=> "s".$row->supplier_id."-c".$row->pcategory_id,
                    'name'=> $row->name,
                    'images'=> $image_path,
                    'items_per_outer'=> $row->items_per_outer,
                    'rrp'=> $row->rrp,
                    'barcode_unit'=> $row->barcode_unit,
                    'product_is_new'=> 0,
                );
                return $ppRow;
            }
        })->toArray();
        $product_categories = array_filter($product_list);
        $supplier_tree_data = array_merge($this->suppliers, $this->categories, $product_categories);
        return $supplier_tree_data;
    }
}
