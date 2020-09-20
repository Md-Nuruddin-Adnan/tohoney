<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function user(){
        return $this->hasOne('App\User', 'id', 'added_by');
    }
}
