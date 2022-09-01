<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



class CategoryController extends Controller
{
 function category(){
        $trashed = Category::onlyTrashed()->get();
        $categories = Category::all();
        return view('admin.category.index', [
        'categories' => $categories,
        'trashed' => $trashed,
    
        ]);
    
    }
    function insert(CategoryRequest $request){
        Category::insert([
            'category_name'=>$request->category_name,
            'added_by'=>Auth::id(),
            'created_at'=>Carbon::now(),
  
         ]);
         return back()->with('success', 'Category Added!');
    }
  function delete($category_id){
       Category::find($category_id)->delete();
       return back()->with('delete', 'category Delected');
       }
   function edit($category_id){
        $edit = Category::find($category_id);
        return view('admin.category.edit',[
            'edit'=>$edit,
        ]);
    }
    function update(CategoryRequest $request){
        Category::where('id',$request->category_id)->update([
            'category_name'=>$request->category_name,
            'updated_at'=>Carbon::now(),
        ]);
        return back()-> with('success','Category Updated!');
      }

      function restore($category_id){
         
        Category::onlyTrashed()->find($category_id)->restore();
        return back()-> with('restore', 'Restored');
       }

       function p_delete($category_id){
        Category::onlyTrashed()->find($category_id)->forceDelete();
        return back()-> with('p_delete', 'Permanent Delete Successful!');
      }
   }
