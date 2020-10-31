<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Blog_category;
use App\Comment;
use App\Reply;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rules\FindOutNumberRule;
use Illuminate\Support\Str;
use Image;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.blog.index', [
            'blogs' => Blog::latest()->get(),
            'blog_categories' => Blog_category::all(),
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
        $request->validate([
            'category_id' => 'required',
            'blog_title' => 'required',
            'blog_description' => 'required',
            'blog_thumbnail_photo' => 'image|max:1000',
            'blog_details_photo' => 'image|max:3000',
        ], [
            'category_id.required' => 'Please select any category',
            'blog_thumbnail_photo.max' => 'The testimonial photo may not be greater than 1MB.' ,
            'blog_details_photo.max' => 'The testimonial photo may not be greater than 3MB.' ,
        ]);
        $blog_id = Blog::insertGetId($request->except('_token', 'blog_thumbnail_photo', 'blog_details_photo') + [
            'user_id' => Auth::id(),
            'slug' => Str::slug($request->blog_title."-".Str::random(9)),
            'created_at' => Carbon::now()
        ]);
        if($request->hasFile('blog_thumbnail_photo')){
            $uploaded_photo = $request->file('blog_thumbnail_photo');
            $new_photo_name =  $blog_id.'.'.$uploaded_photo->getClientOriginalExtension();
            $new_photo_location = 'public/uploads/blog_thumbnail_photos/'.$new_photo_name;
            Image::make($uploaded_photo)->fit(350, 250)->save(base_path($new_photo_location));
            Blog::find($blog_id)->update([
                'blog_thumbnail_photo' => $new_photo_name
            ]);
        }
        if($request->hasFile('blog_details_photo')){
            $uploaded_photo = $request->file('blog_details_photo');
            $new_photo_name =  $blog_id.'.'.$uploaded_photo->getClientOriginalExtension();
            $new_photo_location = 'public/uploads/blog_details_photos/'.$new_photo_name;
            Image::make($uploaded_photo)->fit(870, 500)->save(base_path($new_photo_location));
            Blog::find($blog_id)->update([
                'blog_details_photo' => $new_photo_name
            ]);
        }
        return back()->with('blog_success', 'Blog added successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        return view('admin.blog.edit', [
            'blog_categories' => Blog_category::all(),
            'blog_info' => $blog,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'category_id' => 'required',
            'blog_title' => 'required',
            'blog_description' => 'required',
            'blog_thumbnail_photo' => 'image|max:1000',
            'blog_details_photo' => 'image|max:3000',
        ], [
            'category_id.required' => 'Please select any category',
            'blog_thumbnail_photo.max' => 'The testimonial photo may not be greater than 1MB.' ,
            'blog_details_photo.max' => 'The testimonial photo may not be greater than 3MB.' ,
        ]);

        $blog->update($request->except('_token', '_method', 'blog_thumbnail_photo', 'blog_details_photo'));

        if($request->hasFile('blog_thumbnail_photo')){
            if(Blog::findOrFail($blog->id)->blog_thumbnail_photo != 'default.png'){
                $old_photo_location = 'public/uploads/blog_thumbnail_photos/'.$blog->blog_thumbnail_photo;
                unlink(base_path($old_photo_location));
            }
            $uploaded_photo = $request->file('blog_thumbnail_photo');
            $new_photo_name =  $blog->id.'.'.$uploaded_photo->getClientOriginalExtension();
            $new_photo_location = 'public/uploads/blog_thumbnail_photos/'.$new_photo_name;
            Image::make($uploaded_photo)->fit(350, 250)->save(base_path($new_photo_location));
            
            Blog::findOrFail($blog->id)->update([
                'blog_thumbnail_photo' => $new_photo_name,
            ]);
        }
        if($request->hasFile('blog_details_photo')){
            if(Blog::findOrFail($blog->id)->blog_details_photo != 'default.png'){
                $old_photo_location = 'public/uploads/blog_details_photos/'.$blog->blog_details_photo;
                unlink(base_path($old_photo_location));
            }
            $uploaded_photo = $request->file('blog_details_photo');
            $new_photo_name =  $blog->id.'.'.$uploaded_photo->getClientOriginalExtension();
            $new_photo_location = 'public/uploads/blog_details_photos/'.$new_photo_name;
            Image::make($uploaded_photo)->fit(870, 500)->save(base_path($new_photo_location));
            
            Blog::findOrFail($blog->id)->update([
                'blog_details_photo' => $new_photo_name,
            ]);
        }

        return redirect('blog')->with('edit_success', 'Blog edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        //
    }

    public function delete($blog_id){
       if(Blog::find($blog_id)->blog_thumbnail_photo != 'default.jpg'){
        $old_photo_location = 'public/uploads/blog_thumbnail_photos/'.Blog::find($blog_id)->blog_thumbnail_photo;
        unlink(base_path($old_photo_location));
       }
       if(Blog::find($blog_id)->blog_details_photo != 'default.jpg'){
        $old_photo_location = 'public/uploads/blog_details_photos/'.Blog::find($blog_id)->blog_details_photo;
        unlink(base_path($old_photo_location));
       }
        Blog::findOrFail($blog_id)->forceDelete();
        return back()->with('delete_status', 'Blog deleted!');
    }

    public function comment(Request $request){
        $request->validate([
            'message' => 'required'
        ]);
        Comment::insert([
            'user_id' => Auth::id(),
            'blog_id' => $request->blog_id,
            'message' => $request->message,
            'created_at' => Carbon::now()
        ]);
        return back();
    }

    public function replypost(Request $request){
        $request->validate([
            'comment_id' => 'required|numeric',
            'reply_message' => 'required',
        ]);
        Reply::insert([
            'user_id' => Auth::id(),
            'comment_id' => $request->comment_id,
            'reply_message' => $request->reply_message,
            'created_at' => Carbon::now()
        ]);
        return back();
    }

    
}
