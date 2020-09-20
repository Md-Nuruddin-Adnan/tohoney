<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function productonetoonecategory(){
        return $this->hasOne('App\Category', 'id', 'category_id')->withTrashed();
    }

    public function productonetomanyproduct_image(){
        return $this->hasMany('App\Product_image', 'product_id', 'id')->withTrashed();
    }
}
