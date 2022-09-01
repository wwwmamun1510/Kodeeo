@extends('frontend.master')


@section('content')

<!-- breadcrumb-area start -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-12 text-center">
                <h2 class="breadcrumb-title">Shop</h2>
                <!-- breadcrumb-list start -->
                <ul class="breadcrumb-list">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Checkout</li>
                </ul>
                <!-- breadcrumb-list end -->
            </div>
        </div>
    </div>
</div>

<!-- breadcrumb-area end -->

<div class="container">
    <div class="row">
        <div class="col-lg-8 m-auto">
           <div class="my-5">
                @if(session('order_success'))
                    <div class="alert alert-success">
                        <h3>{{ session('order_success') }}</h3>
                    </div>
                @endif
           </div>
        </div>
    </div>
</div>
@endsection