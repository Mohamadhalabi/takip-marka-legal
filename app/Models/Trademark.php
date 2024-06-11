<?php

namespace App\Models;

use App\Traits\FullTextSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trademark extends Model
{
    use HasFactory, FullTextSearch;

    protected $guarded = [];
    protected $searchable = ['name', 'slug'];

    // Get trademark's bulletin.
    public function bulletin()
    {
        return $this->belongsTo(Media::class, 'bulletin_id', 'id');
    }
}
