<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    protected $guarded = ['id'];
    use SoftDeletes;
    public function user(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function blog_category(){
        return $this->hasOne('App\Blog_category', 'id', 'category_id');
    }
}
