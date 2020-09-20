<?php

function total_product_count(){
  return App\Product::count();
}

function cart_count(){
  return App\Cart::where('generated_cart_id', Cookie::get('g_cart_id'))->count();
}

function cart_items(){
  return App\Cart::where('generated_cart_id', Cookie::get('g_cart_id'))->get();
}

function wishlist_items(){
  return App\Wishlist::where('generated_wishlist_id', Cookie::get('g_wishlist_id'))->get();
}

function wishlist_count(){
  return App\Wishlist::where('generated_wishlist_id', Cookie::get('g_wishlist_id'))->count();
}



