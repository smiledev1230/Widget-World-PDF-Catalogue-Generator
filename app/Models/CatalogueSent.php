<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogueSent extends Model
{
    protected $table = 'catalogue_sent';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pdf_id', 'emails'
    ];

    public function sent()
    {
        return $this->belongsTo('App\Models\Catalogue', 'pdf_id');
    }
}
