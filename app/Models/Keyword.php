<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'keywords';
    protected $fillable =[
        'user_id',
        'keyword',
        'slug',
        'classes'
    ];

    protected $casts = [
        'classes' => 'array',
        'exclusion_keywords' => 'array',
        'keyword_fragments' => 'array'
    ];
}
