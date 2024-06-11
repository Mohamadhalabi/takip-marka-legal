<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $table = 'plans';
    protected $fillable =[
        'plan_name',
        'keyword_limit',
        'search_limit',
        'price'
    ];
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
