<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Category;
use App\Product;
use App\Testimonial;
use App\Banner;
use App\Faq;
use App\Contact;
use Carbon\Carbon;
use Hash;

class FrontendController extends Controller
{
    //welcome blade
    function index(){
        return view('frontend.index', [
            'active_categories' => Category::all(),
            'active_products' => Product::latest()->get(),
            'testimonials' => Testimonial::latest()->get(),
            'banners' => Banner::latest()->get(),
        ]);
    }

    //Contact blade
    function contact(){
        return view('frontend.contact');
    }
    //Contact inserst
    function contactinsert(Request $request){
        $request->validate([
            'contact_name' => 'required',
            'contact_email' => 'required|email',
            'contact_subject' => 'required',
            'contact_message' => 'required',
        ]);
        $contact_id = Contact::insertGetId($request->except('_token')+[
            'created_at' => Carbon::now(),
        ]);
        if($request->hasFile('contact_attachment')){
        //    $uploaded_path = $request->file('contact_attachment')->store('conact_uploads');
            $path = $request->file('contact_attachment')->storeAs(
                'conact_uploads', $contact_id.'.'.$request->file('contact_attachment')->getClientOriginalExtension()
            );
            Contact::findOrFail($contact_id)->update([
                'contact_attachment' => $path,
            ]);
        }
        return back()->with('success_status', 'We received your message');
    }
    // Contact view in dashboard
    public function contactview(){
        return view('admin.contact.index',[
            'contacts' => Contact::latest()->get(),
        ]);
    }

    //Product Details
    function productdetails($slug){
        $product_info = Product::where('slug', $slug)->firstOrFail();
        $related_product = Product::where('category_id', $product_info->category_id)->where('id', '!=', $product_info->id )->limit(4)->get();
        return view('frontend.productdetails', [
            'product_info' => $product_info, 
            'related_product' => $related_product,
            'faqs' => Faq::latest()->get(),
        ]);
    }
    //About blade
    function about(){
        return view('about');
    }
    //ourservice blade
    function ourservice (){
        return view('ourservice');
    }
    //Shop blade
    function shop (){
        return view('frontend.shop', [
            'categories' => Category::all(),
            'products' => Product::all(),
        ]);
    }
    //Faq blade
    function faqpage(){
        return view('frontend.faq', [
            'faqs' => Faq::latest()->get(),
        ]);
    }
    //Customer Register blade
    function customerregister (){
        return view('frontend.customerregister');
    }
    //Customer Register Post
    function customerregisterpost (Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required'
        ]);
        User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now(),
        ]);
    }
}
