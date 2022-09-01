<?php

namespace App\Http\Controllers;

use App\Models\CustomerLogin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    function RedirectToProvider(){
        return Socialite::driver('google')->redirect();
    }
    function RedirectToWebsite(){
        $user = Socialite::driver('google')->user();
        if(CustomerLogin::where('email', $user->getEmail())->exists()){
            if(Auth::guard('customerlogin')->attempt(['email'=>$user->getEmail(), 'password'=>'@abc123'])){
                return redirect('/welcome');
            }
        }else{
            CustomerLogin::create([
                'name'=>$user->getName(),
                'email'=>$user->getEmail(),
                'password'=>bcrypt('@abc123'),
                'created_at'=>Carbon::now(),
            ]);

         if(Auth::guard('customerlogin')->attempt(['email'=>$user->getEmail(), 'password'=>'@abc123'])){
              return redirect('/welcome');
            }
        }

    }
}
