<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogueCover extends Model
{
    protected $table = 'catalogue_covers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cover_url'
    ];
}
