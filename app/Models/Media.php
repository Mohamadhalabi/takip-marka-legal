<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Symfony\Component\Translation\t;

class Media extends Model
{
    use HasFactory;
    protected $table = 'media';
    protected $fillable =[
        'media_id',
        'created_at',
        'slug',
        'type',
        'name',
        'title',
        'mime',
        'size',
        'extension',
        'version',
        'path',
        'data_id',
        'is_official',
        'is_saved',
        'bulletin_no'
        ];

    public function item(){
        return $this->belongsTo(Bulletin::class);
    }
    
    public function trademarks(){
        return $this->hasMany(Trademark::class, 'bulletin_id', 'id');
    }
}
