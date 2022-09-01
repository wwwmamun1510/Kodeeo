<?php

namespace App\Http\Controllers;

use App\Models\CustomerLogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\CustomerEmailVerify;
use App\Models\Order;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
      function update(Request $request){
        User::find(Auth::id())->update([
            'name'=>$request->name,
        ]);
    return back()->with('update_name', 'Update Successful!');
      }
  
  function profile(){
   
        return view('admin.profile.edit');
    }
  
    function pass_update(Request $request){
         $request->validate([
            'password'=> ['required', 'confirmed', Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()]
         ]);
         if(hash::check($request->old_password, auth::user()->password)){
             user::find(Auth::id())->update([
                'password'=>bcrypt($request->password),
             ]);
             return back()->with('update', 'Password Updated');
         }
         else{
            return back()->with('old_pass', 'Old password Incorrect');
         }
    }
    function photo_change(Request $request){
        $request->validate([
            'photo'=>'image',
            'photo'=>'file|max:512',
            
        ]);

        $new_photo = $request->photo;
        $extension = $new_photo->getClientOriginalExtension();
        $new_name = Auth::id().'.'.$extension;

        if(auth::user()->photo != 'default.png'){
            $path = public_path()."/uploads/users/".Auth::user()->photo;
            unlink($path); 
        }

        Image::make($new_photo)-> resize(600, 500)->save(base_path('public/uploads/users/'.$new_name));
        User::find(Auth::id())->update([
            'photo'=>$new_name,
        ]);
        return back()->with('update_photo', 'Update Successful!');       
        
    }

    function email_verify($verify_token){

        $verify_email = CustomerEmailVerify::where('verify_token', $verify_token)->firstOrFail();
        $customer_id = CustomerLogin::findOrFail($verify_email->customer_id);

        $customer_id->update([

            'email_verified_at'=>Carbon::now(),

        ]);
        CustomerEmailVerify::where('id',$verify_email ->id)->delete();
        return redirect('/verify/email/success')->with('verify','Your Account Has Been Verified!');
    }

    function email_verify_success(){

        return view('frontend.verify');
    }

}


