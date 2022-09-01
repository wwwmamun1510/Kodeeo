<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\BillingDetails;
use App\Models\OrderProduct;
use App\Models\Inventory;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;


class CheckoutController extends Controller
{
    public function Checkout()
    {
        $carts = Cart::where('user_id', Auth::guard('customerlogin')->id())->get();
        $countries = Country::all();
        $cities = City::all();
        return view('frontend.checkout', [
            'countries' => $countries,
            'cities' => $cities,
            'carts' => $carts,
        ]);
    }

    function get_city(Request $request){

        $cities = City::where('country_id', $request->country_id)->get();
        $str = '<option>Select a City</option>';
        foreach ($cities as $city) {
            $str .= '<option value="'.$city->id.'">'.$city->name.'</option>';


       }
       echo $str;
    }


    function order_insert(Request $request){
       
          if($request->payment_method == 1){
            $order_id = Order::insertGetId([
                'user_id' => Auth::guard('customerlogin')->id(),
                'sub_total' => $request->sub_total,
                'discount' => $request->discount,
                'delivery_charge'=> $request->delivery_charge,
                'total'=> ($request->sub_total-$request->discount)+$request->delivery_charge,
                'payment_method'=> $request->payment_method,
                'created_at'=>Carbon::now(),
            ]);
    
            BillingDetails::insert([
                'order_id' => $order_id,
                'user_id' =>Auth::guard('customerlogin')->id(),
                'name'=> $request->name,
                'email'=>$request->email,
                'company'=> $request->company,
                'country_id'=> $request->country_id,
                'city_id'=> $request->city_id,
                'postcode'=> $request->postcode,
                'address'=> $request->address,
                'phone'=> $request->phone,
                'notes'=>$request->notes,
                'created_at'=>Carbon::now(),
            ]);
    
            $carts = Cart::where('user_id', Auth::guard('customerlogin')->id())->get();
        
            foreach($carts as $cart){
                OrderProduct::insert([
                    'order_id'=> $order_id,
                    'user_id' => Auth::guard('customerlogin')->id(),
                    'product_id'=> $cart->product_id,
                    'product_price'=>$cart->rel_to_product->discount_price,
                    'color_id'=> $cart->color_id,
                    'size_id'=> $cart->size_id,
                    'quantity'=> $cart->quantity,
                    'created_at'=>Carbon::now(),
                ]);
              }

             $total_amount = ($request->sub_total - $request->discount) + $request->delivery_charge; 
             Mail::to($request->email)->send(new InvoiceMail($order_id));

             //sms send
             $url = "http://66.45.237.70/api.php";
             $number=$request->phone;
             $text="Thank you for purchasing our products, your total amount is: ".$total_amount;
             $data= array(
            'username'=>"Abdullah242",
            'password'=>"5SR2A4EX",
            'number'=>"$number",
            'message'=>"$text"
            );

           $ch = curl_init(); // Initialize cURL
           curl_setopt($ch, CURLOPT_URL,$url);
           curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           $smsresult = curl_exec($ch);
           $p = explode("|",$smsresult);
           $sendstatus = $p[0];

            foreach($carts as $cart){
                Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->color_id)->decrement('quantity', $cart->quantity);
               // Cart::find($cart->id)->delete();

               }
            return redirect()->route('order.success')->with('order_success', 'Your order has been placed!');
          }
          else if($request->payment_method == 2){
               $data = $request->all();
             return view('/sslpayment',[
                'data'=>$data,
              ]);

          }
          else{
             $data = $request->all();
             return view('stripe', compact('data'));
          }

          
     }

     function order_success(){
        return view('frontend.order_success');
    }
    
}
 

   