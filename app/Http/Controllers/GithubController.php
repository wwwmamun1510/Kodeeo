<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;
use App\Models\CustomerLogin;
use Illuminate\Support\Facades\Auth;

class GithubController extends Controller
{
    function RedirectToProvider(){

        return Socialite::driver('github')->redirect();

      }
    function RedirectToWebsite(){
        $user = Socialite::driver('github')->user();
         if(CustomerLogin::where('email', $user->getEmail())->exists()){
            if(Auth::guard('customerlogin')->attempt(['email'=>$user->getEmail(), 'password'=>'@abc123'])){
                return redirect('/welcome');
            } 

        }
        else{
          CustomerLogin::create([
            'name'=>$user->getNickname(),
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
