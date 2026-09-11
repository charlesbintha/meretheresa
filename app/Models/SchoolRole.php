<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolRole extends Model
{
    protected $casts = ['permissions' => 'array', 'is_system' => 'boolean'];
}
