<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function adder(){
        return $this->belongsTo(User::class,'adder_id') ;
    }
    public function verifier(){
        return $this->belongsTo(User::class,'verifier_id') ;
    }
    public function viewer(){
        return $this->belongsTo(User::class,'viewer_id') ;
    }
}
