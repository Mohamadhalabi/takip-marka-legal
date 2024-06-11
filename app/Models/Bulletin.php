<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    use HasFactory;
    protected $table = 'items';
    protected $fillable =[
        'data_id',
        'parent_id',
        'created_at',
        'updated_at',
        'language',
        'name',
        'slug',
        'title',
        'author_id',
        'publish_at',
        'expire_at',
        'order',
        'public',
        'active',
        'version',
        'link',
        'tags',
        'content',
        'link_type',
        'variables',
        'description',
    ];

    public function media(){
        return $this->hasMany(Media::class);
    }
    public function meta(){
        return $this->hasMany(Meta::class);
    }
    public function category(){
        return $this->hasMany(Category::class);
    }
}
