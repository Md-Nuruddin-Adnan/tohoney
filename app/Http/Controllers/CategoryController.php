<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryForm;
use App\Rules\FindOutNumberRule;
use App\Category;
use App\Product;
use Carbon\Carbon;
use Auth;
use Image;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkrole');
    }
    
    function addcategory(){
        return view('admin.category.index', [
            'categories' => Category::latest()->get(),
            'categories_count' => Category::count(),
            'deleted_categories' => Category::onlyTrashed()->get(),
        ]);
    }
    function addcategorypost (CategoryForm $request){
        $category_id = Category::insertGetId([
            'category_name' => $request->category_name,
            'category_description' => $request->category_description,
            'user_id' => Auth::id(),
            'created_at' => Carbon::now(),
        ]);
        if($request->hasFile('category_photo')){
            $uploaded_photo = $request->file('category_photo');
            $new_photo_name =  $category_id.'.'.$uploaded_photo->getClientOriginalExtension();
            $new_photo_location = 'public/uploads/category_photos/'.$new_photo_name;
            Image::make($uploaded_photo)->fit(200, 200)->save(base_path($new_photo_location));
            Category::find($category_id)->update([
                'category_photo' => $new_photo_name
            ]);
        }
        
        return back()->with('success_status', $request->category_name.' Category added successfully');
    }
    function deletecategory($category_id){
        $category_name = Category::find($category_id)->category_name;
        Category::find($category_id)->delete();
        
        return back()->with('delete_status', $category_name.' category is deleted successfylly');
    }
    function editcategory($category_id){
        return view('admin.category.edit', [
            'category_info' => Category::find($category_id)
            // 'category_info' => Category::where('id', $category_id)->first(),
        ]);
    }
    function editcategorypost(Request $request){
        $request->validate([
            'category_name' => ['required', 'unique:categories,category_name,'.$request->category_id],
            'category_description' => 'required'
        ]);

        Category::find($request->category_id)->update([
            'category_name' => $request->category_name,
            'category_description' => $request->category_description
        ]);
        return redirect('add/category')->with('update_status', 'Your category updated successfully');
    }
    function restorecategory($category_id){
        Category::withTrashed()->find($category_id)->restore();
        return back()->with('restore_status', 'Your category restored successfully');
    }
    function markrestorecategory(Request $request){
        if (isset($request->category_id)) {
            foreach ($request->category_id as $cat_id) {
                Category::withTrashed()->find($cat_id)->restore();
            }
            return back()->with('mark_restore_status', 'Mark category restore successfully');
        }
        return back();
    }
    function forcedeletecategory($category_id){
        Category::withTrashed()->find($category_id)->forceDelete();
        Product::withTrashed()->where('category_id',$category_id)->forceDelete();
        return back()->with('forcedelete_status', 'Your category is permanently deleted');
    }
    function markdeletecategory(Request $request){
        if(isset($request->category_id)){
            foreach ($request->category_id as $cat_id) {
                Category::find($cat_id)->delete();
            }
            return back()->with('mark_delete_status', 'Mark category deleted successfully');
        }
        return back();
    }
}
 