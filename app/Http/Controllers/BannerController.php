<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\FindOutNumberRule;
use Auth;
use App\Banner;
use Carbon\Carbon;
use Image;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkrole');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.banner.index', [
            'banners' => Banner::latest()->get(),
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
    public function store(Request $request, Banner $banner)
    {
        $request->validate([
            'banner_title' => ['required', 'unique:banners,banner_title'],
            'banner_description' => 'required',
            'banner_photo' => 'image|max:5000'
        ], [
           'banner_photo.max' => 'The banner photo may not be greater than 5MB.' 
        ]);
        $banner_id = $banner->insertGetId($request->except('_token') + [
            'created_at' => Carbon::now(),
            'user_id' => Auth::id(),
        ]);
            
        if($request->hasFile('banner_photo')){
            $uploaded_photo = $request->file('banner_photo');
            $new_photo_name =  $banner_id.'.'.$uploaded_photo->getClientOriginalExtension();
            $new_photo_location = 'public/uploads/banner_photos/'.$new_photo_name;
            Image::make($uploaded_photo)->fit(1920, 1000)->save(base_path($new_photo_location));
            
            Banner::findOrFail($banner_id)->update([
                'banner_photo' => $new_photo_name,
            ]);
        }
        return back()->with('banner_success_status', 'Banner added successfully');
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
    public function edit(Banner $banner)
    {
        return view('admin.banner.edit', [
            'banner_info' => $banner,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'banner_title' => ['required', 'unique:banners,banner_title,'.$banner->id],
            'banner_description' => 'required',
            'banner_photo' => 'image|max:5000'
        ], [
           'banner_photo.max' => 'The banner photo may not be greater than 5MB.' 
        ]);

        $banner->update($request->except('_token', '_method', 'banner_photo'));
        
        if($request->hasFile('banner_photo')){
            if(Banner::findOrFail($banner->id)->banner_photo != 'default.png'){
                $old_photo_location = 'public/uploads/banner_photos/'.$banner->banner_photo;
                unlink(base_path($old_photo_location));
            }
            $uploaded_photo = $request->file('banner_photo');
            $new_photo_name =  $banner->id.'.'.$uploaded_photo->getClientOriginalExtension();
            $new_photo_location = 'public/uploads/banner_photos/'.$new_photo_name;
            Image::make($uploaded_photo)->fit(1920, 1000)->save(base_path($new_photo_location));
            
            Banner::findOrFail($banner->id)->update([
                'banner_photo' => $new_photo_name,
            ]);
        }
    
        return redirect()->route('banner.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

     // Delete
     public function bannerdelete($banner_id, Banner $banner){
        if(Banner::findOrFail($banner_id)->banner_photo != 'default.png'){
            $old_photo_location = 'public/uploads/banner_photos/'.Banner::findOrFail($banner_id)->banner_photo;
            unlink(base_path($old_photo_location));
        }
        $banner->withTrashed()->findOrFail($banner_id)->forceDelete();
        return back()->with('banner_delete_status', 'Banner deleted successfully');
    }

     // Mark Delete
     public function markdeletebanner(Request $request, Banner $banner){
        if(isset($request->banner_id)){
            foreach ($request->banner_id as $ban_id) {
              if(Banner::findOrFail($ban_id)->banner_photo != 'default.png'){
                  $old_photo_location = 'public/uploads/banner_photos/'.Banner::findOrFail($ban_id)->banner_photo;
                  unlink(base_path($old_photo_location));
              }
              $banner->withTrashed()->findOrFail($ban_id)->forceDelete();
            }
            return back()->with('mark_delete_status', 'Banner mark delete successfully');
        }
        return back();
      }
}
