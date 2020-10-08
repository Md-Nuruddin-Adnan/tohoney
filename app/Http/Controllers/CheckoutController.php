<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Country;
use App\City;
use App\Billing;
use App\Mail\PurchaseConfirm;
use App\Shipping;
use App\Order;
use App\Order_detail;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        return view('frontend.checkout', [
            'countries' => Country::all(),
        ]);
    }
    
    public function getcitylistajax(Request $request){
        $stringToSend = '';
        $cities = City::where('country_id', $request->country_id)->get();
        foreach($cities as $city){
            $stringToSend .= "<option value='".$city->id."'>".$city->name."</option>";
        }
       return $stringToSend;
    }
    
    public function checkoutpost(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'country_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'address' => 'required',
        ]);
        if(isset($request->shipping_address_status)) {
            $request->validate([
                'shipping_name' => 'required',
                'shipping_email' => 'required|email',
                'shipping_phone_number' => 'required',
                'shipping_country_id' => 'required|numeric',
                'shipping_city_id' => 'required|numeric',
                'shipping_address' => 'required',
            ]);
            $shipping_id = Shipping::insertGetId([
                'name' => $request->shipping_name,
                'email' => $request->shipping_email,
                'phone_number' => $request->shipping_phone_number,
                'country_id' => $request->shipping_country_id,
                'city_id' => $request->shipping_city_id,
                'address' => $request->shipping_address,
                'created_at' => Carbon::now()
            ]);
        }
        else{
            $shipping_id = Shipping::insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'address' => $request->address,
                'created_at' => Carbon::now()
            ]);
        }
        $billing_id = Billing::insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
            'notes' => $request->notes,
            'created_at' => Carbon::now()
        ]);
        $order_id = Order::insertGetId([
            'user_id' => Auth::id(),
            'sub_total' => session('cart_sub_total'),
            'discount_amount' => session('discount_amount'),
            'coupon_name' => session('coupon_name'),
            'total' => (session('cart_sub_total') - session('discount_amount')),
            'payment_option' => $request->payment_option,
            'billing_id' => $billing_id,
            'shipping_id' => $shipping_id,
            'created_at' => Carbon::now()
        ]);
        foreach (cart_items() as $cart_item) {
            Order_detail::insert([
                'order_id' => $order_id,
                'product_id' => $cart_item->product_id,
                'product_quantity' => $cart_item->product_quantity,
                'product_price' => $cart_item->product->product_price,
                'created_at' => Carbon::now()
            ]);
            // Product table decrement
            Product::find($cart_item->product_id)->decrement('product_quantity', $cart_item->product_quantity);
        }
        $orders = Order::findOrFail($order_id);
        $order_details = Order_detail::where('order_id', $order_id)->get();
        Mail::to($request->email)->send(new PurchaseConfirm($orders, $order_details));
        if ($request->payment_option == 2) {
            session(['order_id_from_checkout_page' => $order_id]);
            return redirect('stripe');
        }
        else{
            // Delete from carts table
            $cart_item->forceDelete();
            session([
                'cart_sub_total' => '',
                'coupon_name' => '',
                'discount_amount' => '',
                'order_id_from_checkout_page' => '',
            ]);
            return redirect('cart');
        }
    }

    // testsms
    public function testsms(){
        $url = "http://66.45.237.70/api.php";
        $number="8801771117454";
        $text="Hello Adnan, You are the Hero";
        $data= array(
        'username'=>"01771117454",
        'password'=>"86A5GKTZ",
        'number'=>"$number",
        'message'=>"$text"
        );

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("|",$smsresult);
        echo $sendstatus = $p[0];
    }
}
