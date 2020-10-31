<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog_category extends Model
{
    protected $fillable = ['category_name', 'category_description'];
    use SoftDeletes;
    public function user(){
        return $this->hasOne('App\User', 'id', 'created_by');
    }
}
