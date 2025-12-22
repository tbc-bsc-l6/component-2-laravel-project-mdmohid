<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'module',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

}

