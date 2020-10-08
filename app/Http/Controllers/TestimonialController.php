<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\FindOutNumberRule;
use Auth;
use App\Testimonial;
use Carbon\Carbon;
use Image;

class TestimonialController extends Controller
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
        return view('admin.testimonial.index', [
            'testimonials' => Testimonial::latest()->get(),
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
    public function store(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name' => ['required', 'unique:testimonials,name', new FindOutNumberRule],
            'designation' => 'required',
            'message' => 'required',
            'testimonial_photo' => 'image|max:2000'
        ], [
           'testimonial_photo.max' => 'The testimonial photo may not be greater than 2MB.' 
        ]);
        $testimonial_id = $testimonial->insertGetId($request->except('_token') + [
            'created_at' => Carbon::now(),
            'user_id' => Auth::id(),
        ]);
            
        if($request->hasFile('testimonial_photo')){
            $uploaded_photo = $request->file('testimonial_photo');
            $new_photo_name =  $testimonial_id.'.'.$uploaded_photo->getClientOriginalExtension();
            $new_photo_location = 'public/uploads/testimonial_photos/'.$new_photo_name;
            Image::make($uploaded_photo)->fit(200, 200)->save(base_path($new_photo_location));
            
            Testimonial::findOrFail($testimonial_id)->update([
                'testimonial_photo' => $new_photo_name,
            ]);
        }
        return back()->with('testimonial_success_status', 'Testimonial added successfully');
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
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonial.edit', [
            'testimonial_info' => $testimonial,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name' => ['required', 'unique:testimonials,name,'.$testimonial->id, new FindOutNumberRule],
            'designation' => 'required',
            'message' => 'required',
            'testimonial_photo' => 'image|max:2000'
        ], [
           'testimonial_photo.max' => 'The testimonial photo may not be greater than 2MB.' 
        ]);

        $testimonial->update($request->except('_token', '_method', 'testimonial_photo'));

        if($request->hasFile('testimonial_photo')){
            if(Testimonial::findOrFail($testimonial->id)->testimonial_photo != 'default.png'){
                $old_photo_location = 'public/uploads/testimonial_photos/'.$testimonial->testimonial_photo;
                unlink(base_path($old_photo_location));
            }
            $uploaded_photo = $request->file('testimonial_photo');
            $new_photo_name =  $testimonial->id.'.'.$uploaded_photo->getClientOriginalExtension();
            $new_photo_location = 'public/uploads/testimonial_photos/'.$new_photo_name;
            Image::make($uploaded_photo)->fit(200, 200)->save(base_path($new_photo_location));
            
            Testimonial::findOrFail($testimonial->id)->update([
                'testimonial_photo' => $new_photo_name,
            ]);
        }
        return redirect()->route('testimonial.index');
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

    // Delete with alert
    public function testimonialdelete($testimonial_id, Testimonial $testimonial){
        if(Testimonial::findOrFail($testimonial_id)->testimonial_photo != 'default.png'){
            $old_photo_location = 'public/uploads/testimonial_photos/'.Testimonial::findOrFail($testimonial_id)->testimonial_photo;
            unlink(base_path($old_photo_location));
        }
        $testimonial->findOrFail($testimonial_id)->delete();
        return back()->with('Testimonial_delete_status', 'Testimonial deleted sussessfully');
    }

    // Mark Delete
    public function markdeletetestimonial(Request $request){
      if(isset($request->testimonial_id)){
          foreach ($request->testimonial_id as $testi_id) {
            if(Testimonial::findOrFail($testi_id)->testimonial_photo != 'default.png'){
                $old_photo_location = 'public/uploads/testimonial_photos/'.Testimonial::findOrFail($testi_id)->testimonial_photo;
                unlink(base_path($old_photo_location));
            }
            Testimonial::findOrFail($testi_id)->delete();
          }
          return back()->with('mark_delete_status', 'Testimonial mark delete successfully');
      }
      return back();
    }
}
