<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\user;
use Carbon\Carbon;
use Hash;
use Image;
use Mail;
use App\Mail\ChangePasswordMail;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    function profile(){
        return view('admin.profile.index');
    }
    function editprofilepost(Request $request){
        $request->validate([
            'name' => 'required'
        ]);
        if(Auth::user()->updated_at->addDays(30) < Carbon::now()){
            User::find(Auth::id())->update([
                'name' => $request->name
            ]);
            return back()->with('name_change_status', 'Your name changed successfully');
        }else {
            $left_days = Carbon::now()->diffInDays(Auth::user()->updated_at->addDays(30)) + 1;
            return back()->with('name_error', 'You can update your name after '.$left_days.' days');
        }
    }
    function editpasswordpost(Request $request){
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required'
        ]);
        if(Hash::check($request->old_password, Auth::user()->password)){
            if($request->old_password == $request->password){
                return back()->with('password_error', 'Old password is same with new password');
            }
            else {
                User::find(Auth::id())->update([
                    'password' => Hash::make($request->password)
                ]);
                // send a password change notification start
                Mail::to(Auth::user()->email)->send(new ChangePasswordMail(Auth::user()->name));
                return back()->with('password_change_status', 'Your password changed successfully');
                // send a password change notification end
            }
        }
        else {
            return back()->with('password_error', 'Your old password does not match');
        }
    }
    function changeprofilephoto(Request $request){
        $request->validate([
            'profile_photo' => 'required|image'
        ]);
        if($request->hasFile('profile_photo')){
            if(Auth::user()->profile_photo != 'default.png'){
              $old_photo_location = 'public/uploads/profile_photos/'.Auth::user()->profile_photo;
              unlink(base_path($old_photo_location));
            }
            // $watermark = base_path('public/uploads/profile_photos/watermark.png');
            $uploaded_photo = $request->file('profile_photo');
            $new_photo_name =  Auth::id().'.'.$uploaded_photo->getClientOriginalExtension();
            $new_photo_location = 'public/uploads/profile_photos/'.$new_photo_name;
            Image::make($uploaded_photo)->fit(150, 150)->save(base_path($new_photo_location));
            User::find(Auth::id())->update([
                'profile_photo' => $new_photo_name
            ]);
            return back();
        }
        else {
            return back(); 
        }
    }
}
