<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestLimit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'limit',
        'landscape_limit',
        'keyword_limit'
    ];
}
