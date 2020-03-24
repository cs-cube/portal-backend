<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaperSize extends Model
{
    protected $fillable = [
        'description',
        'dimension'
    ];
}
