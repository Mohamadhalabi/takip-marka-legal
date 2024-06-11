<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    use HasFactory;
    protected $table = 'meta';
    protected $fillable =[
        'link',
        'tags',
        'content',
        'link_type',
        'variables',
        'description',
        'data_id',
        ];

    public function item(){
        return $this->belongsTo(Bulletin::class);
    }
}
