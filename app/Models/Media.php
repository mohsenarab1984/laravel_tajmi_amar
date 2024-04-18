<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $guarded = [];
    // public function mediable()
    // {
    //     return $this->morphTo();
    // }
    public function mobls()
    {
        return $this->morphedByMany(Mobl::class, 'mediaable');
    }

    public function blogs()
    {
        return $this->morphedByMany(Blog::class, 'mediaable');
    }
}
