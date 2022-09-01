<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerLoginController extends Controller
{
    function customer_login(Request $request){
    if(Auth::guard('customerlogin')->attempt(['email' => $request->email, 'password' => $request->password])){
        if(Auth::guard('customerlogin')->user()->email_verified_at == null){
            Auth::guard('customerlogin')->logout();
             return redirect()->route('login_register')->with('message', 'You need to verify your email');
               
            }
          else{
           return redirect('/welcome');

           }
       } 
      else{
          
          return redirect('/register');

         }
     }
    function customer_logout(Request $request){
        Auth::guard('customerlogin')->logout();
        return redirect('/customer/register/login');
        
     }

}

