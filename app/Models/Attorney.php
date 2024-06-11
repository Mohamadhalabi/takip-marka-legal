<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attorney extends Model
{
    use HasFactory;
    protected $table = 'attorneys';
    protected $fillable =[
        'number',
        'name',
        'company',
        'city',
        'address',
        'phone',
        'email',
        'last_seen',
        'brand_attorney',
        'patent_attorney',
        'updated_at'
    ];
}
