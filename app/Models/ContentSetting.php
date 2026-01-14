<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public static function getValue(string $key, string $default = ''): string
    {
        return static::query()->where('key', $key)->value('value') ?? $default;
    }
}
