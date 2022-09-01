<?php

namespace App\Http\Controllers;

use App\Models\BillingDetails;
use App\Models\CustomerLogin;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use PDF;


class CustomerController extends Controller
{
    function account(){
        $orders=Order::where('user_id',Auth::guard('customerlogin')->id())->get();
        return view('frontend.Customer_account', [
            'orders'=> $orders,

        ]);
    }

   function account_update(Request $request){
    if(empty($request->password)){

          CustomerLogin::find($request->id)->update([
             'name'=> $request->name,
             'email'=> $request->email,

           ]);
         return back();
    
        }
       else{
         CustomerLogin::find($request->id)->update([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=>bcrypt($request->password),

          ]);
        return back();

        }

      }
      function invoice_download($invoice_id){
          $billing_details = BillingDetails::find($invoice_id);
          $orders = Order::find($invoice_id);
          $products =OrderProduct::where('order_id', $invoice_id)->get();
          $data = [
              'billing_details'=>$billing_details,
              'orders' =>$orders,
          ];
          
          $pdf = PDF::loadView('invoice.invoice', compact('billing_details', 'orders','products'));
          return $pdf->download('spider.pdf');
          }
      }
     
