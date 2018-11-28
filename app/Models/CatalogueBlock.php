<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogueBlock extends Model
{
    protected $table = 'catalogue_block';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pdf_id', 'front_id', 'block_content'
    ];

    public function block()
    {
        return $this->belongsTo('App\Models\Catalogue', 'pdf_id');
    }
}
