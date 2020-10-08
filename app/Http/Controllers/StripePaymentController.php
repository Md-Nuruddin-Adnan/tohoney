<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Order;

class StripePaymentController extends Controller
{
    public function stripe()
    {
        if(session('order_id_from_checkout_page')){
            return view('payment.stripe');
        }
        else{
            abort(404);
        }
    }
    public function stripelet($order_id)
    {
        return view('payment.stripelet', [
            'order_id' => $order_id,
            'order_info' => Order::findOrFail($order_id)
        ]);
    }
    public function stripePost(Request $request)
    {
        $amount = (session('cart_sub_total') - session('discount_amount'));
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => $amount * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Payment from eCommerce. Order ID: ".session('order_id_from_checkout_page')
        ]);
  
        Session::flash('success', 'Payment successful!');
        Order::find(session('order_id_from_checkout_page'))->update([
            'payment_status' => 2,
        ]);
        // Delete from carts table
        foreach(cart_items() as $cart_item){
            $cart_item->forceDelete();
        }
        // Empty session data
        session([
            'cart_sub_total' => '',
            'coupon_name' => '',
            'discount_amount' => '',
            'order_id_from_checkout_page' => '',
        ]);
        return redirect('cart');
    }

    public function stripeLetPost(Request $request)
    {
        $amount = Order::findOrFail($request->order_id)->total;
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => $amount * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Payment from eCommerce. Order ID: ".$request->order_id
        ]);
  
        Session::flash('success', 'Payment successful!');
        Order::find($request->order_id)->update([
            'payment_status' => 2,
        ]);
        // Delete from carts table
        foreach(cart_items() as $cart_item){
            $cart_item->forceDelete();
        }
        // Empty session data
        session([
            'cart_sub_total' => '',
            'coupon_name' => '',
            'discount_amount' => '',
            'order_id_from_checkout_page' => '',
        ]);
        return redirect('cart');
    }
}
