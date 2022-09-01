<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Size;
use App\Models\Color;
use App\Models\Inventory;
use Carbon\Carbon;
use Str;
use Intervention\Image\Facades\Image;
use App\Models\ProductThumbnail;

class ProductController extends Controller
{
    function color_size(){

        $colors= Color::all();
        $sizes= Size::all();
        return view('admin.product.color_size',[
            'colors'=>$colors,
             'sizes'=>$sizes,

        ]);
   }
   function color_insert(Request $request){
        Color::insert ([
            'color_name'=>$request->color_name,
            'color_code'=>$request->color_code,
            'created_at'=> Carbon::now(),
        ]);
      return back();
    }
    function size_insert(Request $request){
        Size::insert ([
            'size_name'=>$request->size_name,
            'created_at'=> Carbon::now(),
        ]);
      return back();
    }
   function index(){
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $products = Product::all();
        return view('admin.product.index', [
            'categories' => $categories,
            'subcategories' => $subcategories,
            'products'=>$products,
        
        ]);
    }

    function getSubcategory(Request $request){

        $subcategories = Subcategory::where('category_id', $request->category_id)->select('id','subcategory_name')->get();
        $str_to_send = '<option>--Select Subcategory--</option>';
        foreach ($subcategories as $subcategory ){
            $str_to_send .= '<option value="'.$subcategory->id.'">'.$subcategory->subcategory_name.'</option>';
        }
        echo $str_to_send;
    }

    function insert(Request $request){

               $product_name = str::lower($request->product_name);
               $product_id = Product::insertGetId([
               'category_id' => $request->category_id,
               'subcategory_id'=> $request->subcategory_id,
               'product_name'=> $request->product_name,
               'product_price'=> $request->product_price,
               'discount'=> $request->discount,
               'discount_price'=>$request->product_price - ($request->product_price * $request->discount)/100,
              'description'=> $request->description,
              'created_at'=> Carbon::now(),
         ]);

    

        $product_image = $request->product_image;
        $extension = $product_image->getClientOriginalExtension();
        $new_product_name = $product_id.'.'.$extension;

       Image::make($product_image)->resize(800, 800)->save(public_path('/uploads/products/preview/').$new_product_name);
     
       Product::find($product_id)->update([
         
        'product_image'=>$new_product_name,
       ]);

       $start=1;
       foreach ($request->file('product_thumb') as $single_thumb){
           $extension = $single_thumb->getClientOriginalExtension();
           $new_product_thumb_name = $product_id.'-'.$start.'.'.$extension;
           Image::make($single_thumb)->resize(800, 800)->save(public_path('/uploads/products/thumbnails/').$new_product_thumb_name);
           ProductThumbnail::insert([
            'product_id'=>$product_id,
            'product_thumbnail_name'=> $new_product_thumb_name,
            'created_at'=>Carbon::now(),
          ]);
         $start++;

    }
   return back()->with('success', 'Product Added!');
  
   }

   function inventory($product_id){
      $colors= Color::all();
      $sizes= Size::all();
      $product_info=Product::find($product_id);
      return view('admin.product.inventory', [
        'colors'=> $colors,
        'sizes'=> $sizes,
        'product_info'=>$product_info,

       ]);
    }
    function inventory_insert(Request $request){
        if(Inventory::where('product_id',$request->product_id)->where('color_id',$request->color_id)->where('size_id', $request->size_id)->exists()){

            Inventory::where('product_id', $request->product_id)->where('color_id',$request->color_id)->where('size_id', $request->size_id)->increment('quantity', $request->quantity);

            return back()->with('success', 'Successfully Added');;
        }
        else{
            Inventory::insert([
                'product_id'=>$request->product_id,
                'color_id'=>$request->color_id,
                'size_id'=>$request->size_id,
                'quantity'=> $request->quantity,
                'created_at'=> Carbon::now(),
            ]);
            return back()->with('success', 'Successfully Added');
        }
    }
}

