<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_cat_regular extends Model
{
    protected $fillable = [
        'grade', 'position', 'desk', 'created_at', 'updated_at'
    ];
}