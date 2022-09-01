<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use App\Http\Requests\SubcategoryRequest;

class SubcategoryController extends Controller
  {
     function index(){
        $trashed = SubCategory::onlyTrashed()->get();
        $subcategories = SubCategory::all();
        $categories = Category::all();
        return view('admin.subcategory.index', [
        'categories'=> $categories,
        'subcategories' => $subcategories,
        'trashed' => $trashed,

      ]);

    }
    function insert(SubcategoryRequest $request){
    if(Subcategory::withTrashed()->where('category_id', $request->category_id)->where('subcategory_name', $request->subcategory_name)->exists()){
            return back()->with('exist', 'Subcategory Name Already Exist in this Category');
        }
        else{
           Subcategory::insert([
                'category_id'=> $request->category_id,
                'subcategory_name'=> $request->subcategory_name,
                'created_at'=> Carbon::now(),
            ]);
            return back()->with('success', 'Subcategory Added!');       
 
        }

        }
        function edit($subcategory_id){

          {
            $categories = Category::all();
            $subcategories=subcategory::find($subcategory_id);
            return view('admin.subcategory.edit', [
            'subcategories'=>$subcategories,
            'categories'=>$categories,
   
         ]);
   
       }
    }
    function update(SubcategoryRequest $request){
      if(Subcategory::where('category_id', $request->category_id)->where('subcategory_name',$request->subcategory_name)->exists()){
          return back()->with('exist', 'You can not update subcategory on this category' );
      }
      else{
          Subcategory::where('id', $request->subcategory_id)->update([
              'subcategory_name'=>$request->subcategory_name,
              'category_id'=>$request->category_id,
              'updated_at'=>Carbon::now(),
          ]);
          return back()->with('success', 'Update Successful!');
      }

      } 

    function delete($subcategory_id){
      Subcategory::find($subcategory_id)->delete();
             return back()->with('delete', 'category Delected');
          
       }
    function restore($subcategory_id){
       SubCategory::onlyTrashed()->find($subcategory_id)->restore();
       return back()-> with('restore', 'Restored');
        
         }

      function p_delete($subcategory_id){

        SubCategory::onlyTrashed()->find($subcategory_id)->forceDelete();
                return back()-> with('p_delete', 'Permanent Delete Successful!');
               }
        }
    