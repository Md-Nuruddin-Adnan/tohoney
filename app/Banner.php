<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function banneronetooneuser(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
