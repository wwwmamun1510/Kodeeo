@extends('layouts.starlight')

@section('category')
active
@endsection

@section('title')
Category
@endsection

@section('content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
<nav class="breadcrumb sl-breadcrumb">
<a class="breadcrumb-item" href="{{url('/home')}}">Home</a>
<a class="breadcrumb-item" href="{{url('/category')}}">Categories</a>
</nav>
  <div class="sl-pagebody">
    <section>
      <div class="container">
        <div class="row">
           <div class="col-lg-8">
           <div class="card">
               <div class="card-header">
                <h3 class="text-center">Categories Information</h3>
            </div>
           @if(session('delete'))
               <div class="alert alert-success mt-1 ">{{session('delete')}}</div>
           @endif
           <div class="card-body">
             <table class="table table-bordered">
                <tr>
                  <th>SL</th>
                  <th>Category Name</th>
                  <th>Added By</th>
                  <th>Created At</th>
                  <th>Action</th>
                 </tr>
                 @foreach ($categories as $category)
                 <tr>
                   <td>{{$loop->index+1}}</td>
                   <td>{{$category->category_name}}</td>
                   <td>{{App\Models\User::find($category->added_by)->name}}</td>
                   <td>{{$category->created_at->diffforHumans()}}</td>
                   <td>
                       <a href="{{url('/category/edit')}}/{{$category->id}}" class="btn btn-success">Edit</a>
                       <a href="{{url('/category/delete')}}/{{$category->id}}" class="btn btn-danger">Delete</a>
                      
                   </td>
                 </tr>
                 @endforeach
                </table>
               </div>
            </div>
            <div class="card mt-5">
               <div class="card-header">
                <h3>Trashed Information</h3>
           </div>
           @if(session('restore'))
               <div class="alert alert-success mt-1">{{session('restore')}}</div>
           @endif
           @if(session('p_delete'))
               <div class="alert alert-warning mt-1">{{session('p_delete')}}</div>
           @endif
           <div class="card-body">
             <table class="table table-bordered">
                <tr>
                  <th>SL</th>
                  <th>Category Name</th>
                  <th>Added By</th>
                  <th>Created At</th>
                  <th>Action</th>
                 </tr>
                 @foreach ($trashed as $category)                                                                                                                                                                                                   )
                 <tr>
                   <td>{{$loop->index+1}}</td>
                   <td>{{$category->category_name}}</td>
                   <td>{{App\Models\User::find($category->added_by)->name}}</td>
                   <td>{{$category->created_at->diffforHumans()}}</td>
                   <td>
                   <a href="{{url('/category/restore')}}/{{$category->id}}" class="btn btn-info">Restore</a>
                   <a href="{{url('/category/permanent/delete')}}/{{$category->id}}" class="btn btn-danger">Delete</a>
                      
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
                    <h3>Add Categories Information</h3>
                  </div>
                  @if(session('success'))
                     <div class="alert alert-success mt-1 ">{{session('success')}}</div>
                  @endif
                  <div class="card-body">
                  <form action="{{url('/category/insert')}}" method="POST">
                     @csrf
                    <div class="form-group">
                       <label for="" class="form-label">Category Name</label>
                       <input type="text" class="form-control" name="category_name">
                       @error('category_name')
                           <strong class="text-danger pt-2">{{$message}}</strong>
                       @enderror
                     </div>
                     <div class="form-group mt-3 text-center">
                        <button type="submit" class="btn btn-primary">Add Category</button>
                     </div>
                    </form>
                </div>
               </div>
            </div>
         </div>
     </div>
</section>
</div><!-- sl-pagebody -->
</div><!-- sl-mainpanel -->
<!-- ########## END: MAIN PANEL ########## -->
@endsection