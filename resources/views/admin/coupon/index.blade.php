@extends('layouts.starlight')

@section('Coupon')
active
@endsection

@section('title')
   Coupon
@endsection

@section('content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="#">Home</a>
      <a class="breadcrumb-item" href="#">Coupon</a>
    </nav>

  <div class="sl-pagebody">
  <div class="">
      <div class="row">
              <div class="col-lg-8">
                  <div class="card">
                      <div class="card-header">
                          <h3>Coupon Information List</h3>
                      </div>
                      <div class="card-body">
                          <table class="table table-bordered">
                              <tr>
                                  <th>SL</th>
                                  <th>Coupon Name</th>
                                  <th>Validity</th>
                                  <th>Discount</th>
                                  <th>Created At</th>
                              </tr>
                              @foreach ($coupons as $key =>$coupon)
                              <tr>
                                  <td> {{$key+1}} </td>
                                  <td>{{$coupon->coupon_name}}</td>
                                  <td>{{ $coupon->validity }}</td>
                                  <td>{{ $coupon->discount }}</td>
                                  <td>{{($coupon->created_at-> diffInHours() > 24)?$coupon->created_at : $coupon->created_at-> diffforHumans()}}</td>
                              @endforeach
                          </table>
                      </div>
                  </div>
              </div>
              <div class="col-lg-4">
                  <div class="card">
                      <div class="card-header">
                          <h2 class="card-title text-center size " >Add Coupon</h2>
                      </div>
                      @if (session('success'))
                          <div class="alert alert-success mt-1 ">{{session('success')}}</div>
                      @endif
                      <div class="card-body">
                          <form action="{{url('/coupon/insert')}}" method="POST">
                              @csrf
                              <div class="form-group">
                                  <label for="" class="form-label">Coupon Name</label>
                                  <input type="text" class="form-control" name="coupon_name">
                              </div>
                              <div class="form-group">
                                  <label for="" class="form-label">Coupon Validity</label>
                                  <input type="date" class="form-control" name="validity">
                              </div>
                              <div class="form-group">
                                  <label for="" class="form-label">Discount %</label>
                                  <input type="text" class="form-control" name="discount">
                              </div> 
                              <div class="form-group pt-2 text-center">
                                  <button type="submit" class="btn btn-primary">Add Coupon</button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div><!-- sl-pagebody -->
</div><!-- sl-mainpanel -->
  <!-- ########## END: MAIN PANEL ########## -->
@endsection