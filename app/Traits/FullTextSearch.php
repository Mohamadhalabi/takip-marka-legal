<?php
namespace App\Traits;
use Illuminate\Support\Str;

trait FullTextSearch
{
    public function scopeSearch($query, $term)
    {

        //Searched for similar data
        $query->orWhereRaw("MATCH (name,slug) AGAINST (? IN BOOLEAN MODE)" , $term);
        return $query;
    }
}