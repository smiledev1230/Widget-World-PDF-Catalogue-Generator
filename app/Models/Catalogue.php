<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalogue extends Model
{
    protected $table = 'catalogue_pdf';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'logo_name', 'logo_url', 'cover_index', 'suppliers', 'categories', 'display_type', 'page_columns', 'logos_options', 'display_options', 'barcode_options', 'supplier_new', 'category_new', 'supplier_block', 'category_block', 'saved_page', 'pdf_path', 'state', 'drag_supplier_ids', 'drag_category_ids'
    ];

}
