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
                    <li class="breadcrumb-item active">Cart</li>
                </ul>
                <!-- breadcrumb-list end -->
            </div>
        </div>
    </div>
</div>

<!-- breadcrumb-area end -->
 <!-- Cart Area Start -->
 <div class="cart-main-area pt-100px pb-100px">
        <div class="container">
            <h3 class="cart-page-title">Your cart items</h3>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <form action="{{ url('/cart/update') }}" method="post">
                   @csrf
                        <div class="table-content table-responsive cart-table-content">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Until Price</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php 
                                $total =0;
                                @endphp
                                @forelse($carts as $cart)
                                    <tr>
                                        <td class="product-thumbnail">
                                            <a href="#"><img class="img-responsive ml-15px"
                                                    src="{{ asset('uploads/products/preview') }}/{{ $cart->rel_to_product->product_image }}" alt="" /></a>
                                        </td>
                                        <td class="product-name"><a href="#">{{ $cart->rel_to_product->product_name }}</a></td>
                                        <td class="product-price-cart"><span class="amount">TK {{ $cart->rel_to_product->discount_price }}</span></td>
                                        <td class="product-quantity">
                                            <div class="cart-plus-minus">
                                                <input class="cart-plus-minus-box" type="text" name="quantity[{{ $cart->id }}]"
                                                    value="{{ $cart->quantity }}" />
                                            </div>
                                        </td>
                                        <td class="product-subtotal">TK {{ $cart->rel_to_product->discount_price*$cart->quantity }}</td>
                                        <td class="product-remove">
                                             <a href="{{ route('cart.delete', $cart->id) }}"><i class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                    @php
                                      $total += $cart->rel_to_product->discount_price*$cart->quantity;
                                  @endphp
                                 @empty
                                 <tr>
                                    <td colspan="6" >
                                        <h3 class="text-center" >Cart Is Empty</h3>
                                    </td>
                                 </tr>
                                 @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="cart-shiping-update-wrapper">
                                    <div class="cart-shiping-update">
                                        <a href="{{url('/')}}">Continue Shopping</a>
                                    </div>
                                    <div class="cart-clear">
                                        <button type="submit">Update Shopping Cart</button>
                                        <a href="{{ route('cart.clear') }}">Clear Shopping Cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 mb-lm-30px">
                            <div class="discount-code-wrapper">
                                <div class="title-wrap">
                                    <h4 class="cart-bottom-title section-bg-gray">Use Coupon Code</h4>
                                </div>
                                @if ($message)
                                    <div class="alert alert-warning">{{$message}}</div>
                                @endif
                                <div class="discount-code">
                                    <p>Enter your coupon code if you have one.</p>
                                      <form action="{{ url('/cart') }}" method="GET" >
                              <input id="coupon_code" type="text" name="coupon_code" value="{{@$_GET['coupon_code']}}">
                              <button id="coupon_btn" class="cart-btn-2" type="submit">Apply Coupon</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 mt-md-30px">
                            <div class="grand-totall">
                                <div class="title-wrap">
                                    <h4 class="cart-bottom-title section-bg-gary-cart">Cart Total</h4>
                             </div>
                             <h3>
                              @php 
                                   $after_discount = ($total*$discount)/100;
                                @endphp
                            </h3>  
                            <h5>Total Amount<span>TK {{$total}}</span></h5>
                            <h5>Discount <span>{{ $discount }}%</span></h5>
                            <h5>Discount Amount<span>TK {{($total*$discount)/100}}</span></h5>
                            <h4 class="grand-totall-title">Grand Total <span>{{$total - $after_discount}}</span></h4>
                             @php 
                                session([
                                    'discount'=>($total*$discount)/100,
                                ]);
                            @endphp
                               <a href="{{route('checkout')}}">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Area End -->

@endsection
@section('footer_script')
<script>
    $('#coupon_btn').click(function(){
        var coupon_code = $('#coupon_code').val();
        var current_link = '{{url('/cart')}}';
        var link_to_go = current_link+'/'+coupon_code;
        window.location.href = link_to_go;
    })
</script>
@endsection
