<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    protected $fillable = [
        'external_code',
        'number',
        'status',
        'name',
        'updated_at_original',
    ];
}

