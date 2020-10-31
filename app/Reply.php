<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reply extends Model
{
    protected $guarded = ['id'];
    use SoftDeletes;
    public function user(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function comment(){
        return $this->belongsTo('App\Comment');
    }
}
