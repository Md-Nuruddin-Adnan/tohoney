<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Mail;
use App\Mail\NewsLetter;

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
        return view('home', [
            'users' => User::latest()->paginate(10),
            'total_users' => User::count(),
            'total_sum' => User::sum('id'),
            'avg_users' => User::sum('id') / User::count(),
        ]);
    }

    function sendnewsletter(){
        foreach (User::all()->pluck('email') as $email) {
            Mail::to($email)->send(new NewsLetter());
        }
        return back()->with('newsletter_success_status', 'Newsletter send successfully');
    }
}
