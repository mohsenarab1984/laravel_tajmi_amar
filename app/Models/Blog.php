<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    public $timestamps = true;
    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function my_media(){
        return $this->belongsToMany(Media::class,'mediaables','mediaable_id','media_id')->where('mediaable_type',Blog::class);
    }
}
