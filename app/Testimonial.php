<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $guarded = [];

    public function testimonialonetooneuser(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
