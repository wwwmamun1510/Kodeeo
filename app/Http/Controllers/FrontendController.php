<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Size;
use App\Models\Order;
use App\Models\CustomerLogin;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Auth; 


class FrontendController extends Controller
{
    function welcome(){
        $all_categories = Category::all();
        $all_products= Product::all();
        $top_category= Category::take(3)->get();
        $new_products= Product::latest()->take(6)->get();
        return view('frontend.index', [
            'all_categories'=> $all_categories,
            'all_products'=>$all_products,
            'top_category'=>$top_category,
            'new_products'=>$new_products,
     
        ]);
    }
     function admin(){

        return view('layouts.starlight');
    }

    function product_details($product_id){
        $product_info = Product::find($product_id);
        $related_products = Product::where('category_id', $product_info->category_id)->where('id', '!=', $product_id)->get();
        $available_colors = Inventory::where('product_id', $product_id)->groupBy('color_id')->selectRaw('count(*) as total, color_id')->get();
        $review_total=OrderProduct::where('product_id',$product_id)->whereNotNull('star')->count('star');
        $review = OrderProduct::where('product_id', $product_info->id)->whereNotNull('review')->get();
        return view('frontend.product_details', [
            'product_info'=>$product_info,
            'available_colors'=>$available_colors,
            'related_products'=>$related_products,
            'review'=> $review,
            'review_total'=>$review_total,
            
             ]);

        }

        function getsize(Request $request){
            $sizes =  Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get('size_id');

            $size_name_sent = '';
            foreach ($sizes as $size){
                $size_name = Size::find($size->size_id)->size_name;
                $size_name_sent .= '<li><a name="'.$size->size_id.'" class="gray size_id">'.$size_name.'</a></li>';
            }
            echo $size_name_sent;
        }

         function profile(){
        
              return view('frontend.profile');
        }
        function profile_update(Request $request){
            CustomerLogin::find(Auth::guard('customerlogin')->user())->update([
                'name' => $request->name,
                'password' => bcrypt($request->password),
    
            ]);
            return back();
        }

        function review_insert(Request $request){
            OrderProduct::where('user_id', Auth::guard('customerlogin')->id())->where('product_id', $request->product_id)->update([
                'review'=>$request->review,
                'star'=>$request->star,
        
            ]);

            return back();

        }
 
    }