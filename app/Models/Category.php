<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable =[
        'category_id',
        'category_slug',
        'category_name',
        'category_title',
        'meta_poster',
        'meta_description',
        'data_id',
    ];

    public function item(){
        return $this->belongsTo(Bulletin::class);
    }
}
