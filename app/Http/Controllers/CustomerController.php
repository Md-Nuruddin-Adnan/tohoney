<?php

namespace App\Http\Controllers;

use App\Order;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function home(){
        return view('customer.home', [
            'orders' => Order::with('order_detail')->where('user_id', Auth::id())->get(),
        ]);
    }
    public function customerinvoicedownload($order_id){
        $order_info = Order::findOrFail($order_id);
        $pdf = PDF::loadView('pdf.invoice', compact('order_info'));
        return $pdf->download('invoice(ID'. $order_id .').pdf');

        // Open in new window
        // return $pdf->stream();
    }
}
