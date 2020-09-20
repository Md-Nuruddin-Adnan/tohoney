<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index($coupon_name = ""){
        $error_message = '';
        $discount_amount = 0;
        if($coupon_name == ""){
            $error_message = '';
        }
        else{
            if(!Coupon::where('coupon_name', $coupon_name)->exists()){
                $error_message = 'This coupon does not match!';
            }
            else{
                if(Carbon::now()->format('Y-m-d') > Coupon::where('coupon_name', $coupon_name)->first()->validity_till){
                    $error_message = 'This coupon has been expired';
                }
                else{
                    $sub_total = 0;
                    foreach(cart_items() as $cart_item){
                       $sub_total += $cart_item->product->product_price * $cart_item->product_quantity;
                    }
                    if(Coupon::where('coupon_name', $coupon_name)->first()->minimum_purchase_amount > $sub_total){
                        $error_message = "You have to buy more than $".Coupon::where('coupon_name', $coupon_name)->first()->minimum_purchase_amount;
                    }
                    else{
                       $discount_amount = Coupon::where('coupon_name', $coupon_name)->first()->discount_amount;
                    }
                }
            }
        }
        $valid_coupons = Coupon::whereDate('validity_till', '>=', Carbon::now()->format('Y-m-d'))->get();
        return view('frontend.cart', compact('error_message', 'discount_amount', 'coupon_name', 'valid_coupons'));
    }

    public function store(Request $request){
        if(Cookie::get('g_cart_id')){
            $generated_cart_id = Cookie::get('g_cart_id');
        }
        else{
            $generated_cart_id = Str::random(7).rand(1, 1000);
            Cookie::queue('g_cart_id', $generated_cart_id, 1440);
        }

        if(Cart::where('generated_cart_id', $generated_cart_id)->where('product_id', $request->product_id)->exists()){
            Cart::where('generated_cart_id', $generated_cart_id)->where('product_id', $request->product_id)->increment('product_quantity', $request->product_quantity);
        }
        else{
            Cart::insert([
                'generated_cart_id' =>  $generated_cart_id,
                'product_id' => $request->product_id,
                'product_quantity' => $request->product_quantity,
                'created_at' => Carbon::now()
            ]);
        }
       return back();
    }
    public function remove($cart_id){
        Cart::findOrFail($cart_id)->delete();
       return back()->with('remove_status', 'Product remove from cart!');
    }
    public function update(Request $request){
       foreach ($request->cart_info as $cart_id => $product_quantity) {
           if($product_quantity < 1){
                return back()->with('update_error_status', 'Product quantity is invalid!');
           }
           else{
                Cart::findOrFail($cart_id)->update([
                    'product_quantity' => $product_quantity,
                ]);
           }
       }
       return back()->with('update_status', 'Product update!');
    }
}
