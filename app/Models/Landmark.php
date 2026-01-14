<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Landmark extends Model
{
    protected $fillable = [
        'title',
        'description',
        'distance',
        'map_link',
        'image_url',
        'category',
    ];
}
