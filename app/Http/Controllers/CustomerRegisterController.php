<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerLogin;
use App\Models\CustomerEmailVerify;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CustomerEmailVerifyNotification;
use Carbon\Carbon;

class CustomerRegisterController extends Controller
{
    function customer_register(Request $request){
        if(CustomerLogin::where('email', $request->email)->exists()){
            return back()->with('exist', 'Email is already registered');
       }
       else{
          CustomerLogin::insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'created_at'=>Carbon::now(),
        ]);
           
        $customer = CustomerLogin::where('email', $request->email)->firstOrFail();
        $remove_info = CustomerEmailVerify::where('customer_id', $customer->id)->delete();

        $email_verify = CustomerEmailVerify::create([
            'customer_id'=>$customer->id,
            'verify_token'=>uniqid(),
         ]);



        Notification::send($customer, new CustomerEmailVerifyNotification($email_verify));

        return back()->with('customer', 'Register Successfully, We Have Sent a Verification Email, Please Check Your Email & Verify' );
    }
}
function customer_reg(){
    return view('frontend.customer_register');
   }
}
