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
        'name', 'logo_name', 'logo_url', 'cover_index', 'suppliers', 'categories', 'display_type', 'page_columns', 'logos_options', 'display_options', 'barcode_options', 'product_new', 'blocks', 'saved_page', 'pdf_path', 'state'
    ];

}
