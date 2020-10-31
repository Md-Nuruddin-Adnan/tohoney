<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Mail;
use App\Mail\NewsLetter;
use App\Order;
use App\Product;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkrole');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_stock_price = 0;
        foreach(Product::all() as $product){
            $total_stock_price += $product->product_price * $product->product_quantity;
        }
        return view('home', [
            'users' => User::latest()->paginate(10),
            'total_users' => User::count(),
            'paid' => Order::where('payment_status', 2)->count(),
            'unpaid' => Order::where('payment_status', 1)->count(),
            'refund' => Order::where('payment_status', 3)->count(),
            'total_sell' => Order::where('payment_status', 2)->sum('total'),
            'total_stock_price' => $total_stock_price
        ]);
    }

    function sendnewsletter(){
        foreach (User::all()->pluck('email') as $email) {
            Mail::to($email)->queue(new NewsLetter());
        }
        return back()->with('newsletter_success_status', 'Newsletter send successfully');
    }
}
