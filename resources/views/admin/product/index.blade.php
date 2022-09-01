@extends('layouts.starlight')


@section('content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{url('/home')}}">Home</a>
        <a class="breadcrumb-item" href="">Products</a>
          </nav>
           <div class="sl-pagebody">
              <div class="row">
              <div class="col-lg-6 m-auto">
              <div class="card">
              <div class="card-header">
               <h3 class="text-center">Add Product Information</h3>
             </div>
             @if(session('success'))
               <div class="alert alert-success">{{ session('success') }}</div>
             @endif
            <div class="card-body">
            <form action="{{url('/product/insert')}}" method="POST" enctype="multipart/form-data">
              @csrf 
              <div class="mt-3">
                 <select name="category_id" class="form-control select_category">
                   <option value="">--Selected Category--</option>
                   @foreach($categories as $category)
                      <option value="{{$category->id}}">{{$category->category_name}}</option>
                   @endforeach
                 </select>
              </div>
              <div class="mt-3">
                 <select name="subcategory_id" class="form-control" id="subcategory_id">
                   <option value="">--Selected Subcategory--</option>
                   </select>
              </div>
              <div class="mt-3">
                  <label for="" class="form-label">Product Name</label>
                  <input type="text" class="form-control" name="product_name">
               </div>
               <div class="mt-3">
                  <label for="" class="form-label">Product Price</label>
                  <input type="text" class="form-control" name="product_price">
               </div>
               <div class="mt-3">
                   <label for="" class="form-label">Discount %</label>
                   <input type="text" class="form-control" name="discount">
              </div>
              <div class="mt-3">
                  <label for="" class="form-label">Description</label>
                  <textarea name="description" id="summernote" class="form-control"></textarea>
              </div>
              <div class="mt-3">
                   <label for="" class="form-label">Product Image</label>
                   <input type="file" class="form-control" name="product_image">
               </div>
               <div class="mt-3">
                    <label for="" class="form-label">Product Thumbnails</label>
                    <input multiple type="file" class="form-control" name="product_thumb[]">
                 </div>
                 <div class="mt-3 text-center">
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
             </form>
            </div>
           </div>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
                 <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Products List Information</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>SL</th>
                                <th>Product Name</th>
                                <th>Product Price</th>
                                <th>Discount %</th>
                                <th>Discount Price</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                            @foreach($products as $key=>$product)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->product_price }}</td>
                                <td>{{ $product->discount }}</td>
                                <td>{{ $product->discount_price }}</td>
                                <td>{{ substr($product->description, 0, 50).'....more' }}</td>
                                <td>
                                    <img width="50" src="{{asset('uploads/products/preview')}}/{{ $product->product_image}}" alt="">
                                </td>
                                <td>
                                  <a href="{{Route('inventory', $product->id)}}" class="btn btn-info">Inventory</a>
                                   <a href="#" class="btn btn-success">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                      </table>
                  </div>
               </div>
          </div>
      </div>
   </div>
  </div>
@endsection

@section('footer_script')
<script>
  $('.select_category').change(function(){
      var category_id = $(this).val();

      $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });

   $.ajax({
            type: 'POST',
            url: '/getSubcategory',
            data:{category_id :category_id},
            success: function(data){
                $('#subcategory_id').html(data);
            }
        })
    });
  // In your Javascript (external .js resource or <script> tag)
  $(document).ready(function() {
      $('.select_category').select2();
  });

$(document).ready(function() {
    $('#summernote').summernote();
});
 </script>
 @endsection
