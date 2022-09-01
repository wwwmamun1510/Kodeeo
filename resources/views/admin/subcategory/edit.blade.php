@extends('layouts.starlight')

@section('subcategory')
active
@endsection

@section('title')
Edit Subcategory
@endsection

@section('content')

<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
<nav class="breadcrumb sl-breadcrumb">
<a class="breadcrumb-item" href="{{url('/home')}}">Home</a>
<a class="breadcrumb-item" href="{{url('/subcategory')}}">Subcategories</a>
<span class="breadcrumb-item active">Edit Subcategory</span>
</nav>
<div class="sl-pagebody">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 m-auto">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-center" >Edit Subcategory</h3>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success mt-1 ">{{session('success')}}</div>
                        @endif
                        @if (session('exist'))
                            <div class="alert alert-danger mt-1 ">{{session('exist')}}</div>
                        @endif
                        <div class="card-body">
                            <form action="{{url('/subcategory/update')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <select name="category_id" class="form-control">
                                        <option value="">--Select Category--</option>
                                        @foreach ($categories as $category)
                                        <option value="{{$category->id}}" {{($category->id ==$subcategories->category_id)?'selected':''}} >{{$category->category_name}} </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                                <div class="form-group mt-2">
                                    <label for="" class="form-label">Subcategory Name</label>
                                    <input type="text" name="subcategory_name" class="form-control" value="{{$subcategories-> subcategory_name}}" >
                                    <input type="hidden" name="subcategory_id" value="{{$subcategories->id}}" >
                                    @error('subcategory_name')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                                <div class="form-group mt-2 text-center">
                                    <button type="submit" class="btn btn-primary">Update Subcategory</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </section>
 </div><!-- sl-page-title -->
 </div><!-- sl-pagebody -->
 </div><!-- sl-mainpanel -->
<!-- ########## END: MAIN PANEL ########## -->
@endsection















