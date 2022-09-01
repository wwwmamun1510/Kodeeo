@extends('layouts.starlight')

@section('subcategory')
active
@endsection

@section('title')
Subcategory
@endsection

@section('content')

<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
<nav class="breadcrumb sl-breadcrumb">
<a class="breadcrumb-item" href="{{('/home')}}">Home</a>
<a class="breadcrumb-item" href="{{('/subcategory')}}">Subcategory</a>
</nav>
<div class="sl-pagebody">
<section>
<div class="container">
   <div class="row">
   <div class="col-lg-8">
     <div class="card">
        <div class="card-header">
            <h3 class="text-center" >Subcategories Information</h3>
        </div>
         @if(session('delete'))
              <div class="alert alert-warning mt-1">{{session('delete')}}</div>
         @endif
        <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Category Name</th>
                            <th>Subcategory Name</th> 
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($subcategories as $subcategory)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{App\Models\Category::find($subcategory->category_id)->category_name}}</td>
                            <td>{{$subcategory->subcategory_name}}</td>
                            <td>{{$subcategory->created_at-> diffforHumans()}}</td>
                            <td>
                                <a href="{{url('/subcategory/edit')}}/{{$subcategory->id}}" class="btn btn-info">Edit</a>
                                <a href="{{url('/subcategory/delete')}}/{{$subcategory->id}}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="card mt-5">
        <div class="card-header">
            <h3 class="text-center" >Trashed Information</h3>
          </div>
          @if(session('restore'))
            <div class="alert alert-success mt-1">{{session('restore')}}</div>
          @endif
          @if(session('p_delete'))
            <div class="alert alert-danger mt-1">{{session('p_delete')}}</div>
           @endif
            <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Category Name</th>
                            <th>Subcategory Name</th> 
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($trashed as $subcategory)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{App\Models\Category::find($subcategory->category_id)->category_name}}</td>
                            <td>{{$subcategory->subcategory_name}}</td>
                            <td>{{$subcategory->created_at-> diffforHumans()}}</td>
                            <td>
                               <a href="{{url('/subcategory/restore')}}/{{$subcategory->id}}" class="btn btn-info">Restore</a>
                               <a href="{{url('/subcategory/permanent/delete')}}/{{$subcategory->id}}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
       <div class="col-lg-4">
         <div class="card">
           <div class="card-header">
            <h3>Add Subcategories Information</h3>
            </div>
             @if(session('success'))
            <div class="alert alert-success mt-1">
            {{session('success')}}
           </div>
            @endif
            @if(session('exist'))
            <div class="alert alert-warning mt-1">{{session('exist')}}</div>
           @endif
        <div class="card-body">
       <form action="{{url('/subcategory/insert')}}" method="POST">
         @csrf
          <div class="form-group">
                <select name="category_id" class="form-control">
                 <option value="">--Select Category--</option>
                   @foreach ($categories as $category)
                     <option value="{{$category->id}}">{{$category->category_name}}</option>
                   @endforeach
                 </select>
                 @error('category_id')
                  <strong class="text-danger">{{$message}}</strong>
                 @enderror
                 </div>
               <div class="form-group mt-3">
                <label for="" class="form-label">Subcategory Name</label>
                <input type="text" name="subcategory_name" class="form-control" >
                @error('subcategory_name')
                  <strong class="text-danger mt-2">{{$message}}</strong>
                @enderror
              </div>
              <div class="form-group mt-3 text-center">
               <button type="submit" class="btn btn-primary">Add Subcategory</button>
            </div>
          </form>
          </div>
      </div>
     </div>
  </div>
</section>
</div><!-- sl-pagebody -->
</div><!-- sl-mainpanel -->
<!-- ########## END: MAIN PANEL ########## -->
@endsection