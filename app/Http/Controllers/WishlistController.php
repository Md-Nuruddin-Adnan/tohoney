<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wishlist;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;


class WishlistController extends Controller
{
    public function index(){
        return view('frontend.wishlist');
    }

    public function store($product_id){
        if(Cookie::get('g_wishlist_id')){
            $generated_wishlist_id = Cookie::get('g_wishlist_id');
        }
        else{
            $generated_wishlist_id = Str::random(7).rand(1, 1000);
            Cookie::queue('g_wishlist_id', $generated_wishlist_id, 1440);
        }
        if(Wishlist::where('generated_wishlist_id', $generated_wishlist_id)->where('product_id', $product_id)->exists()){
            return back();
        }
        else{
            Wishlist::insert([
                'generated_wishlist_id' => $generated_wishlist_id,
                'product_id' => $product_id,
                'created_at' => Carbon::now(),
            ]);
        }
        return back();
    }

    public function remove($wishlist_id){
        Wishlist::findOrFail($wishlist_id)->forceDelete();
        return back();
    }
}
