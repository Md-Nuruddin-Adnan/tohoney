<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    function index(){
        return view('test');
    }

    // test form data
    function test_form_post(Request $request){

        echo $request->name;
        echo $request->email;
        echo $request->phone_number;
    }

    public function contactmessagepost(Request $request){
        $request->all();
    }

}
