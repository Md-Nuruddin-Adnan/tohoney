<?php

namespace App\Http\Controllers;

use Hash;
use App\Faq;
use App\User;
use App\Banner;
use App\Blog;
use App\Blog_category;
use App\Contact;
use App\Product;
use App\Category;
use App\Comment;
use Carbon\Carbon;
use App\Testimonial;
use App\Order_detail;
use App\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class FrontendController extends Controller
{
    //welcome blade
    function index(){
        $best_sellers = DB::table('order_details')
                 ->select('product_id', DB::raw('count(*) as total'))
                 ->groupBy('product_id')
                 ->get();
        $best_seller_after_desc = $best_sellers->sortByDesc('total')->take(4);
      
        return view('frontend.index', [
            'active_categories' => Category::all(),
            'active_products' => Product::latest()->get(),
            'testimonials' => Testimonial::latest()->get(),
            'banners' => Banner::latest()->get(),
            'best_seller_after_desc' => $best_seller_after_desc,
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
                
        $order_details_id = 0;
        $show_review_form = 0;
        if(Order_detail::where('user_id', Auth::id())->where('product_id', $product_info->id)->whereNull('review')->exists()){
            $order_details_id = Order_detail::where('user_id', Auth::id())->where('product_id', $product_info->id)->whereNull('review')->first()->id;
            $show_review_form = 1;
        }
        else{
            $show_review_form = 2;
        }
        $reviews = Order_detail::where('product_id', $product_info->id)->whereNotNull('review')->latest()->get();
        return view('frontend.productdetails', [
            'product_info' => $product_info, 
            'related_product' => $related_product,
            'faqs' => Faq::latest()->get(),
            'order_details_id' => $order_details_id,
            'show_review_form' => $show_review_form,
            'reviews' => $reviews,
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
            'email' => 'required|email|unique:App\User,email',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required'
        ]);
        User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 2,
            'created_at' => Carbon::now(),
        ]);
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('customer/home');
        }
        return back();
    }
    public function reviewpost(Request $request){
        $request->validate([
            'stars' => 'required',
            'review' => 'required'
        ], [
            'stars.required' => 'Please select any starts',
            'review.required' => 'Please write a review',
        ]);
        Order_detail::find($request->order_details_id)->update([
            'stars' => $request->stars,
            'review' => $request->review,
        ]);
        return back();
    }
    public function search(){
        $search_result = QueryBuilder::for(Product::class)
        ->allowedFilters(['product_name', 'category_id', 'id'])
        ->defaultSort('-id')
        ->allowedSorts('id')
        ->get();

        return view('frontend.search',[
            'search_result' => $search_result
        ]);
    }

    public function blogpage(){
        return view('frontend.blog', [
            'blogs' => Blog::latest()->paginate(6),
        ]);
    }

    public function blogdetails($slug){
        if(is_numeric($slug)){
            $blog_info = Blog::findOrFail(Blog::where('id', '>', $slug)->min('id'));
        }
        else{
            $blog_info = Blog::where('slug', $slug)->first();
        }

        // $blog_info = Blog::where('slug', $slug)->first();
        $blog_categories = Blog_category::latest()->get();
        $related_blogs = Blog::where('category_id', $blog_info->category_id)->where('id', '!=', $blog_info->id)->limit(4)->latest()->get();
        $comments = Comment::with('user')->where('blog_id', $blog_info->id)->latest()->get();
        
        return view('frontend.blogdetails', [
            'blog_info' => $blog_info,
            'blog_categories' => $blog_categories,
            'related_blogs' => $related_blogs,
            'comments' => $comments,
            'total_comments' => $comments->count(),
        ]);
    }

    public function nextpost($blog_id){
        // get the current user
       $blog = Blog::find($blog_id);

        // get previous user id
       echo 'previous is:'. $previous = Blog::where('id', '<', $blog->id)->max('id');
echo '<br>';
        // get next user id
       echo 'next is:'. $next = Blog::where('id', '>', $blog->id)->min('id');
    }
}
