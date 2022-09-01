<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = Auth::id();
        $all_users = User::where('id', '!=', $user_id)->Paginate(10);
        $total_user = User::count();
        $logged_user = Auth::user()->name;
        return view('home',compact('all_users','total_user' ,'logged_user'));
    }

    function add_users(Request $request){
        User::insert([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password),
            'role'=> $request->role,
            'created_at'=> Carbon::now(),
        ]);
        return back();
    }
}
