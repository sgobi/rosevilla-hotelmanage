<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeEvent extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'icon',
        'sort_order',
    ];
}
