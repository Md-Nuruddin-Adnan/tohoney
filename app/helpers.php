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

function review_customer_count($product_id){
  return App\Order_detail::where('product_id', $product_id)->whereNotNull('review')->count();
}

function average_star($product_id){
  return round(App\Order_detail::where('product_id', $product_id)->whereNotNull('review')->avg('stars'));
}

function total_alert_product(){
  // return App\Product::where('product_quantity', '<=', 'product_alert_quantity')->count();
  return DB::table('products')->whereRaw('product_alert_quantity >= product_quantity')->count();
}



