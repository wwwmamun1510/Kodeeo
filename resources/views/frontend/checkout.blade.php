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
 <!-- checkout area start -->
 <div class="checkout-area pt-100px pb-100px">
        <div class="container">
        <form action="{{ url('/order/insert') }}" method="post">
           @csrf
            <div class="row">
                <div class="col-lg-7">
                    <div class="billing-info-wrap">
                        <h3>Billing Details</h3>
                        <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="billing-info mb-4">
                        <label>Name</label><input type="text" name="name" placeholder="Enter Your Name" value="
                        {{ Auth::guard('customerlogin')->user()->name }}" readonly/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="billing-info mb-4">
                                <label>Email Address</label>
                                <input type="text" name="email" placeholder="Enter Your Email" value="{{ Auth::guard('customerlogin')->user()->email}}" readonly />
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="billing-info mb-4">
                                <label>Company Name</label>
                                <input type="text" name="company" placeholder="Enter Your Company Name" />
                            </div>
                        </div>
                            <div class="col-lg-6">
                            <div class="billing-select mb-4">
                                <label>Country</label>
                                <select name="country_id" id="country" >
                                    <option>Select a country</option>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id}}" >{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="billing-select mb-4">
                                <label>City</label>
                                <select name="city_id" id="city">
                                    <option>Select a City</option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="billing-info mb-4">
                                <label>Address</label>
                                <input class="billing-address" placeholder="Enter Your Address" type="text" name='address' />
                            </div>
                        </div>
                            <div class="col-lg-6 col-md-6">
                            <div class="billing-info mb-4">
                                <label>Postcode / ZIP</label>
                                <input type="number" name="postcode" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="billing-info mb-4">
                                <label>Phone</label>
                                <input type="text" name="phone" />
                            </div>
                        </div>
                    </div>
                    <div class="additional-info-wrap">
                        <h4>Additional information</h4>
                        <div class="additional-info">
                            <label>Order notes</label>
                            <textarea placeholder="Notes about your order, e.g. special notes for delivery. "
                                name="notes"></textarea>
                        </div>
                    </div>
                </div>
            </div>
                <div class="col-lg-5 mt-md-30px mt-lm-30px ">
                    <div class="your-order-area">
                        <h3>Your order</h3>
                        <div class="your-order-wrap gray-bg-4">
                            <div class="your-order-product-info">
                                <div class="your-order-top">
                                    <ul>
                                        <li>Product</li>
                                        <li>Total</li>
                                    </ul>
                                </div>
                                <div class="your-order-middle">
                                    <ul>
                                     @php 
                                        $total = 0;
                                     @endphp
                                      @foreach ($carts as $cart)
                                      <li>
                                        <span class="order-middle-left">{{ $cart->rel_to_product->product_name }} X {{ $cart->quantity }} </span>  
                                        <span class="order-price"> {{ $cart->rel_to_product->discount_price*$cart->quantity }} </span>
                                    </li>
                                      @php 
                                        $total += $cart->rel_to_product->discount_price*$cart->quantity;
                                      @endphp
                                      @endforeach
                                    </ul>
                                </div>
                                <div class="your-order-middle">
                                    <ul>
                                      <li>
                                        <span class="order-middle-left">Discount</span>
                                        @php 
                                          $discount = session('discount');
                                        @endphp  
                                        <span class="order-price">{{ $discount }}</span>
                                       </l>
                                    </ul>
                                </div>
                                <div class="your-order-bottom">
                                  <div class="">
                                    <h5>Delivery Location</h5>
                                    <input  style="width:15px; height:15px" class="charge" type="radio" name="delivery_charge" value="60">Inside Dhaka (60 TK)
                                    <br>
                                    <input  style="width:15px; height:15px" class="charge" type="radio" name="delivery_charge" value="100">Outside Dhaka (100 TK)
                                </div>
                              </div>
                               <input type="hidden" name="sub_total" value="{{ $total }}">
                               <input type="hidden" name="discount" value="{{ $discount }}">
                                <div class="your-order-total">
                                    <input type='hidden' id="total" value="{{ $total-$discount }}" />
                                    <ul>
                                        <li class="order-total">Total</li>
                                        <li id="grand_total">{{ $total-$discount }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="payment-method">
                            <div class="payment-accordion element-mrg">
                                <div id="faq" class="panel-group">
                                    <h3>Select Payment Method</h3>
                                    <input style="width:15px; height:15px" class="" type="radio" name="payment_method"  value="1"> Cash On Delivery
                                    <br>
                                    <input style="width:15px; height:15px" class="" type="radio" name="payment_method"  value="2"> Pay With SSLCommers
                                    <br>
                                    <input style="width:15px; height:15px" class="" type="radio" name="payment_method"  value="3"> Pay With Stripe
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="Place-order mt-25">
                       <button type="submit" class="btn btn-danger py-3 px-5">Place Order</button> 
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
</div>
    <!-- checkout area end -->
@endsection
@section('footer_script')
<script>
       $('#country').select2();
       $('#country').change(function(){
        var country_id = $(this).val();


        $.ajaxSetup({
           headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    $.ajax({
        type:'POST',
        url:'/getcity',
        data:{'country_id':country_id},
        success:function(data){
            $('#city').html(data);
            $('#city').select2();
            
        }
    });

 })
</script>
<script>
    $('.charge').click(function(){ 
        var charge = $(this).val();
        var total = $('#total').val();
        var grand_total = parseInt(total)+parseInt(charge);
        $('#grand_total').html(grand_total);
      
    })
</script>
@endsection