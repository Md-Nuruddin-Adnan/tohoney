<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\Order_detail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.order.index', [
            'orders' => Order::with('order_detail')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->update([
            'payment_status' => 2
        ]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function cancel($order_id)
    {
        $order_details = Order_detail::where('order_id', $order_id)->get();
        foreach($order_details as $order_detail){
            Product::find($order_detail->product_id)->increment('product_quantity', $order_detail->product_quantity);
        }
        Order::find($order_id)->update([
            'order_status' => 5, //cencel status is 5
        ]);
        // payment status 2 is "paid"
        if(Order::find($order_id)->payment_status == 2){
            Order::find($order_id)->update([
                'order_status' => 5, //cencel status is 5
                'payment_status' => 3, //refund status is 3
            ]);
        }
        return back();
    }
}
