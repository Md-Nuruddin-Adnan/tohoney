<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    protected $fillable = ['payment_status', 'order_status'];
    use SoftDeletes;
    public function order_detail(){
        return $this->hasMany('App\Order_detail');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
