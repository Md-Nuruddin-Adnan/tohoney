<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Category;
use App\Product;
use App\Product_image;
use Carbon\Carbon;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.product.index', [
        'active_categories' => Category::all(),
        'products' => Product::latest()->get(),
        'deleted_products' => Product::onlyTrashed()->get(),
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
            'product_name' => 'required',
            'product_short_description' => 'required',
            'product_long_description' => 'required',
            'product_price' => 'required|numeric',
            'product_quantity' => 'required|numeric',
            'product_alert_quantity' => 'required|numeric',
            'product_thumbnail_photo' => 'image',
        ], [
            'category_id.required' => 'Please select any product category'
        ]);
        $product_id = Product::insertGetId($request->except('_token', 'product_thumbnail_photo', 'product_multiple_photo') + [
            'slug' => Str::slug($request->product_name."-".Str::random(9)),
            'created_at' => Carbon::now()
        ]);
        if($request->hasFile('product_thumbnail_photo')){
            $uploaded_photo = $request->file('product_thumbnail_photo');
            $new_photo_name =  $product_id.'.'.$uploaded_photo->getClientOriginalExtension();
            $new_photo_location = 'public/uploads/product_photos/'.$new_photo_name;
            Image::make($uploaded_photo)->fit(600, 622)->save(base_path($new_photo_location));
            Product::find($product_id)->update([
                'product_thumbnail_photo' => $new_photo_name
            ]);
        }
        if($request->hasFile('product_multiple_photo')){
            $flag = 1;
           foreach ($request->file('product_multiple_photo') as $single_photo) {
              $uploaded_photo = $single_photo;
              $new_photo_name =  $product_id.'-'.$flag.'.'.$uploaded_photo->getClientOriginalExtension();
              $new_photo_location = 'public/uploads/product_multiple_photos/'.$new_photo_name;
              Image::make($uploaded_photo)->fit(600, 622)->save(base_path($new_photo_location));
              $flag++;
              Product_image::insert([
                  'product_id' => $product_id,
                  'product_multiple_image' => $new_photo_name,
                  'created_at' => Carbon::now()
              ]);
           } 
        }
        return back()->with('product_status', 'Your product added successfully');
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
    public function edit(Product $product)
    {
        return view('admin.product.edit', [
            'active_categories' => Category::all(),
            'product_info' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->except('_token', '_method'));
        return redirect('product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return back();
    }

    // Delete with alert
    public function alertdelete($product_id, Product $product){
        $product->findOrFail($product_id)->delete();
        return back();
    }

    // Force Delete
    public function forcedelete($product_id, Product $product){
        Product::withTrashed()->findOrFail($product_id)->forceDelete();
        return back();
    }

    // Restore
    public function restoreproduct($product_id, Product $product){
        Product::withTrashed()->findOrFail($product_id)->restore();
        return back();
    }
}
