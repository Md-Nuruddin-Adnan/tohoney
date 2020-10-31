<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Blog_category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rules\FindOutNumberRule;

class Blog_categoryController extends Controller
{
    // Blog Category
    public function category(){
        return view('admin.blog.category', [
            'blog_categories' => Blog_category::with('user')->get(),
        ]);
    }
    public function categorystore(Request $request, Blog $blog){
        $request->validate([
            'category_name' => ['required', 'unique:blog_categories,category_name', new FindOutNumberRule],
            'category_description' => 'required',
        ]);
        Blog_category::insert([
            'category_name' => $request->category_name,
            'category_description' => $request->category_description,
            'created_by' => Auth::id(),
            'created_at' => Carbon::now(),
        ]);
        return back()->with('category_success', $request->category_name.' Category added successfully');
    }
    public function categorydelete($category_id){
        Blog_category::findOrFail($category_id)->forceDelete();

        foreach(Blog::where('category_id',$category_id)->get() as $blog){
            if($blog->blog_thumbnail_photo != 'default.jpg'){
                $old_photo_location = 'public/uploads/blog_thumbnail_photos/'.$blog->blog_thumbnail_photo;
                unlink(base_path($old_photo_location));
            }
            if($blog->blog_details_photo != 'default.jpg'){
                $old_photo_location = 'public/uploads/blog_details_photos/'.$blog->blog_details_photo;
                unlink(base_path($old_photo_location));
            }
        }

        Blog::withTrashed()->where('category_id',$category_id)->forceDelete();
        return back()->with('category_delete_status', 'Category deleted!');
    }
    public function categoryedit($category_id){
        return view('admin.blog.categoryedit', [
            'category_info' => Blog_category::with('user')->findOrFail($category_id),
        ]);
    }
    public function categoryeditpost (Request $request, Blog $blog){
        $request->validate([
            'category_name' => ['required', new FindOutNumberRule, 'unique:blog_categories,category_name,'.$request->category_id],
            'category_description' => 'required',
        ]);
        Blog_category::findOrFail($request->category_id)->update([
            'category_name' => $request->category_name,
            'category_description' => $request->category_description,
        ]);
        return redirect('blog/category')->with('category_edit_success', $request->category_name.' Category Edit successfully');
    }
}
