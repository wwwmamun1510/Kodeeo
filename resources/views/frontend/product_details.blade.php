@extends('frontend.master')


@section('content')

<!-- breadcrumb-area start -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-12 text-center">
                <h2 class="breadcrumb-title">Products Details</h2>
                <!-- breadcrumb-list start -->
                <ul class="breadcrumb-list">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Products Details</li>
                </ul>
                <!-- breadcrumb-list end -->
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb-area end -->
<!-- Product Details Area Start -->
<div class="product-details-area pt-100px pb-100px">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-12 col-xs-12 mb-lm-30px mb-md-30px mb-sm-30px">
                    <!-- Swiper -->
                    <div class="swiper-container zoom-top">
                        <div class="swiper-wrapper">
                            @foreach (App\Models\ProductThumbnail::where('product_id',$product_info->id)->get() as $product_thumbnail)
                            <div class="swiper-slide">
                                <img class="img-responsive m-auto" src="{{ asset('uploads/products/thumbnails') }}/{{$product_thumbnail->product_thumbnail_name }}"
                                    alt="">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="swiper-container zoom-thumbs mt-3 mb-3">
                        <div class="swiper-wrapper">
                           @foreach (App\Models\ProductThumbnail::where('product_id',$product_info->id)->get() as $product_thumbnail)
                            <div class="swiper-slide">
                                <img class="img-responsive m-auto" src="{{ asset('uploads/products/thumbnails') }}/{{$product_thumbnail->product_thumbnail_name }}"
                                    alt="">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 col-xs-12" data-aos="fade-up" data-aos-delay="200">
                <form action="{{ url('/cart/insert') }}" method="post"> 
                  @csrf
                    <div class="product-details-content quickview-content">
                        <h2>{{ $product_info->product_name }}</h2>
                        <div class="pricing-meta">
                            <ul>
                                <li class="old-price not-cut">BDT {{ $product_info->discount_price }}</li>
                            </ul>
                        </div>
                        <div class="pro-details-rating-wrap">
                            <div class="rating-product">
                            @for($i=1;$i<=$review->first()->star;$i++)
                               <i class="fa fa-star"></i>
                            @endfor
                            </div>
                            <span class="read-review"><a class="reviews" href="#">( {{ $review_total?$review_total:'' }} Customer Review )</a></span> 
                        </div>
                        @if (App\Models\Inventory::where('product_id', $product_info->id)->where('color_id', 15)->exists())
                        <input type="hidden" name="color_id" value="15">       
                        <div class="pro-details-color-info d-flex align-items-center">
                            <span>Color</span>
                            <div class="pro-details-color">
                                <ul>
                                @foreach ($available_colors as $color)
                                <li><a class="color_id" name="{{ $color->color_id }}" style="background:{{App\Models\Color::find($color->color_id)->color_code}}"></a></li>
                                @endforeach
                                <input type="hidden" id="color_id" name="color_id" value="">
                                </ul>
                            </div>
                        </div>
                        @endif
                        <!-- Sidebar single item -->
                        @if(App\Models\Inventory::where('product_id', $product_info->id)->where('size_id', 13)->exists())
                        <input type="hidden" name="size_id" value="13">     
                        @else
                        <div class="pro-details-size-info d-flex align-items-center">
                            <span>Size</span>
                            <div class="pro-details-size">
                                <ul id="size_info">
                                    <li><a class="gray" href="#">XS</a></li>
                                    <li><a class="gray" href="#">S</a></li>
                                    <li><a class="gray" href="#">M</a></li>
                                    <li><a class="gray" href="#">L</a></li>
                                    <li><a class="gray" href="#">XXL</a></li>
                                    <li><a class="gray" href="#">XL</a></li>
                                </ul>
                               <input type="hidden" id="size_id" name="size_id" value="">
                            </div>
                        </div>
                        @endif
                        <p class="m-0">{!!$product_info->description!!}</p>
                        <div class="pro-details-quality">
                            <div class="cart-plus-minus">
                                <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1" />
                            </div>
                            <div class="pro-details-cart">
                            @auth('customerlogin')
                                <button class="add-cart" type="submit">Add To Carts</button>
                                @else
                                <a  href="{{ route('login_register') }}" class="add-cart">Add To Cart</a>
                            @endauth
                              
                            </div>
                            <div class="pro-details-compare-wishlist pro-details-wishlist ">
                                <a href="wishlist.html"><i class="pe-7s-like"></i></a>
                            </div>
                            <div class="pro-details-compare-wishlist pro-details-compare">
                                <a href="compare.html"><i class="pe-7s-refresh-2"></i></a>
                            </div>
                            <input type="hidden" name="product_id"  value="{{$product_info->id}}">
                          </div>
                          <div class="pro-details-sku-info pro-details-same-style  d-flex">
                            <span>SKU: </span>
                            <ul class="d-flex">
                                <li>
                                    <a href="#">Ch-256xl</a>
                                </li>
                            </ul>
                        </div>
                        <div class="pro-details-categories-info pro-details-same-style d-flex">
                            <span>Categories: </span>
                            <ul class="d-flex">
                                <li>
                                    <a href="#">{{App\Models\Category::find($product_info->category_id)->category_name }}</a>
                                </li>
                                <li> , </li>
                                <li>
                                    <a href="#">{{App\Models\Subcategory::find($product_info->subcategory_id)->subcategory_name }}</a>
                                </li>
                            </ul>
                            </ul>
                        </div>
                        <div class="pro-details-social-info pro-details-same-style d-flex">
                            <span>Share: </span>
                            <ul class="d-flex">
                                <li>
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-google"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-youtube"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>


    <!-- product details description area start -->
    <div class="description-review-area pb-100px" data-aos="fade-up" data-aos-delay="200">
        <div class="container">
            <div class="description-review-wrapper">
                <div class="description-review-topbar nav">
                    <a data-bs-toggle="tab" href="#des-details2">Information</a>
                    <a class="active" data-bs-toggle="tab" href="#des-details1">Description</a>
                    <a data-bs-toggle="tab" href="#des-details3">Reviews (02)</a>
                </div>
                <div class="tab-content description-review-bottom">
                    <div id="des-details2" class="tab-pane">
                        <div class="product-anotherinfo-wrapper text-start">
                            <ul>
                                <li><span>Weight</span> 400 g</li>
                                <li><span>Dimensions</span>10 x 10 x 15 cm</li>
                                <li><span>Materials</span> 60% cotton, 40% polyester</li>
                                <li><span>Other Info</span> American heirloom jean shorts pug seitan letterpress</li>
                            </ul>
                        </div>
                    </div>
                    <div id="des-details1" class="tab-pane active">
                        <div class="product-description-wrapper">
                            <p>{!!$product_info->description!!}</p>
                        </div>
                    </div>
                    <div id="des-details3" class="tab-pane">
                    @if(App\Models\OrderProduct::where('product_id', $product_info->id)->whereNotNull('review')->exists())
                            <div class="row">
                            <div class="col-lg-7">
                                <div class="review-wrapper">
                                    <div class="single-review">
                                        <div class="review-img">
                                            <img src="assets/images/review-image/1.png" alt="" />
                                        </div>
                                        <div class="review-content">
                                            <div class="review-top-wrap">
                                                <div class="review-left">
                                                    <div class="review-name">
                                                    <h4>{{App\Models\Customerlogin::find($review->first()->user_id)->name}}</h4>
                                                    </div>
                                                    <div class="rating-product">
                                                    @for ($i=1;$i<=$review->first()->star;$i++)
                                                        <i class="fa fa-star"></i>
                                                    @endfor
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="review-bottom">
                                                <p>
                                                {{$review->first()->review}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                            @auth('customerlogin')
                            @if (App\Models\OrderProduct::where('user_id', Auth::guard('customerlogin')->id())->where('product_id', $product_info->id)->exists())
                                <div class="ratting-form-wrapper pl-50">
                                    <h3>Add a Review</h3>
                                    <div class="ratting-form">
                                    <form action="{{route('review.insert')}}" method="POST">
                                        @csrf
                                         <div class="star-box">
                                                <span>Your rating:</span>
                                                <div class="rating-product">
                                                    <i name="1" class="fa fa-star"></i>
                                                    <i name="2" class="fa fa-star"></i>
                                                    <i name="3" class="fa fa-star"></i>
                                                    <i name="4" class="fa fa-star"></i>
                                                    <i name="5" class="fa fa-star"></i>
                                                </div>
                                                <input type="hidden" id="star" name="star" value="">
                                             </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="rating-form-style">
                                                    <input type="hidden" name="product_id" value="{{$product_info->id}}">
                                                   <input value="{{Auth::guard('customerlogin')->user()->name}}" type="text" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="rating-form-style">
                                                    <input value="{{Auth::guard('customerlogin')->user()->email}}" type="email" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="rating-form-style form-submit">
                                                        <textarea name="review" placeholder="Message"></textarea>
                                                        <button class="btn btn-primary btn-hover-color-primary "
                                                            type="submit" value="Submit">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                               @endif
                            @endauth
                            </div>
                        </div>
                        @else
                        <div class="row">
                           <div class="col-lg-12">
                            <h3 class="text-center">No Review To Show</h3>
                         </div>
                      </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- product details description area end -->

    <!-- Related product Area Start -->
    <div class="related-product-area pb-100px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center mb-30px0px line-height-1">
                        <h2 class="title m-0">Related Products</h2>
                    </div>
                </div>
            </div>
            <div class="new-product-slider swiper-container slider-nav-style-1 small-nav">
                <div class="new-product-wrapper swiper-wrapper">
                @foreach ($related_products as $r_product)
                    <div class="new-product-item col-lg-3 ">
                        <!-- Single Prodect -->
                        <div class="product">
                            <div class="thumb">
                                <a href="{{ route('product.details', $r_product->id) }}" class="image">
                                    <img src="{{ asset('uploads/products/preview') }}/{{ $r_product->product_image}}" alt="Product" />
                                </a>
                                <span class="badges">
                                    <span class="new">New</span>
                                    @if ($r_product->discount)
                                    <span class="sale">{{ $r_product->discount }}% Off</span>
                                    @endif
                                </span>
                                <div class="actions">
                                    <a href="wishlist.html" class="action wishlist" title="Wishlist"><i
                                            class="pe-7s-like"></i></a>
                                    <a href="#" class="action quickview" data-link-action="quickview"
                                        title="Quick view" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"><i class="pe-7s-search"></i></a>
                                    <a href="compare.html" class="action compare" title="Compare"><i
                                            class="pe-7s-refresh-2"></i></a>
                                </div>
                                <button title="Add To Cart" class=" add-to-cart">Add
                                    To Carts</button>
                            </div>
                            <div class="content">
                                <span class="ratings">
                                    <span class="rating-wrap">
                                        <span class="star" style="width: 100%"></span>
                                    </span>
                                    <span class="rating-num">( 5 Review )</span>
                                </span>
                                <h5 class="title"><a href="{{ route('product.details', $r_product->id) }}">{{ $r_product->product_name }}</a>
                                </h5>
                                <span class="price">
                                    <span class="new">{{ $r_product->discount_price }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Add Arrows -->
                <div class="swiper-buttons">
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Related product Area End -->
@endsection

@section('footer_script')
<script>
     $('.color_id').click(function(){
        var color_id = $(this).attr('name');
        var product_id = "{{ $product_info->id }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type:'POST',
            url:'/getSize',
            data:{product_id:product_id, color_id:color_id},
            success:function(data){
                $('#size_info').html(data);
                   
                $('.size_id').click(function(){
                   var size_id = $(this).attr('name'); 
                   $('#size_id').attr('value', size_id);
               
                });
            }
        });

    });
</script>
<script>
    $('.color_id').click(function(){
       var color_id = $(this).attr('name'); 
       $('#color_id').attr('value', color_id);
    });   
</script>
<script>
    $('.fa_star').click(function(){
       var star = $(this).attr('name'); 
       $('#star').attr('value', star);
    });   
</script>
@if (session('cart_added')){
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
        })

        Toast.fire({
        icon: 'success',
        title: '{{session('cart_added')}}'
        })
</script>
@endif
@endsection