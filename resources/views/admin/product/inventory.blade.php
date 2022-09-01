@extends('layouts.starlight')

@section('content')

<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="{{url('/home')}}">Home</a>
    <a class="breadcrumb-item" href="{{url('/category')}}">Category</a>
    <a class="breadcrumb-item">Edit Category</a>
    </nav>
    <div class="sl-pagebody">
        <div class="row">
            <div class="col-lg-8"></div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Add Inventory</h3>
                    </div>
                    @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="card-body">
                        <form action="{{url('/inventory/insert')}}" method="post">
                            @csrf
                            <div class="mt-3">
                                <label for="" class="form-label">Product Name</label>
                                <input type="hidden" readonly name="product_id" value="{{$product_info->id}}" class="form-control">
                                <input type="text" readonly name="product_name" value="{{$product_info->product_name}}" class="form-control">
                            </div>
                            <div class="mt-3">
                               <select name="color_id" class="form-control">
                                <option value="">--Select Color--</option>
                                  @foreach($colors as $color)
                                      <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                                  @endforeach
                                  </select>
                                </div>
                                <div class="mt-3">
                                  <select name="size_id" class="form-control">
                                    <option value="">--Select Size--</option>
                                 @foreach($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                                 @endforeach
                              </select>
                            </div>
                            <div class="mt-3">
                                <label class="form-lavel">Product Quantity</label>
                                <input type="text" name="quantity" class="form-control" >
                            </div>
                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-info">Add Inventory</button>
                           </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- sl-pagebody -->
</div><!-- sl-mainpanel -->
<!-- ########## END: MAIN PANEL ########## -->
@endsection