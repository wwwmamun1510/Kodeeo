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
                  <li class="breadcrumb-item active">Login</li>
              </ul>
              <!-- breadcrumb-list end -->
          </div>
      </div>
  </div>
</div>

<!-- breadcrumb-area end -->

<!-- login area start -->
<div class="login-register-area pt-100px pb-100px">
  <div class="container">
      <div class="row">
          <div class="col-lg-7 col-md-12 ml-auto mr-auto">
              <div class="login-register-wrapper">
                  <div class="login-register-tab-list nav">
                      <a class="active" data-bs-toggle="tab" href="#lg1">
                          <h4>Register</h4>
                      </a>
                      <a data-bs-toggle="tab" href="#lg2">
                          <h4>Login</h4>
                      </a>
                  </div>
                  <div class="tab-content">
                      <div id="lg1" class="tab-pane active">
                        <div class="login-form-container">
                            <div class="login-register-form">
                        
                                <form action="{{ url('/customer/register') }}" method="POST">
                                    @csrf
                                    @if(session('customer'))
                                    <div class="alert alert-warning mt-1">
                                        {{session('customer')}}
                                    </div>
                                    @endif
                                    @if(session('exist'))
                                    <div class="alert alert-warning mt-1">
                                        {{session('exist')}}
                                    </div>
                                    @endif
                                    @if(session('message'))
                                    <div class="alert alert-warning mt-1">
                                        {{session('message')}}
                                    </div>
                                    @endif
                                    <input type="text" name="name" placeholder="Name" />

                                    <input name="email" placeholder="Email" type="email" />
                                      <input type="password" name="password" placeholder="Password" />
                                    <div class="button-box">
                                        <button type="submit"><span>Register</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                      </div>
                      <div id="lg2" class="tab-pane">
                        <div class="login-form-container">
                            <div class="login-register-form">
                                <form action="{{ url('/customer/login') }}" method="POST">
                                  @csrf
                                    <input type="email" name="email" placeholder="Email" />
                                    <input type="password" name="password" placeholder="Password" />
                                    <div>
                                       <a href="{{url('/github/redirect')}}" class="btn btn-secondary my-2 py-2">login with GitHub</a>
                                       <a href="{{url('/google/redirect')}}" class="btn btn-warning my-2 py-2">login with Google</a>
                                     </div>
                                    <div class="button-box">
                                        <div class="login-toggle-btn">
                                            <input type="checkbox" />
                                            <a class="flote-none">Remember me</a>
                                            <a href="{{route('pass.reset')}}">Forgot Password?</a>
                                        </div>
                                        <button type="submit"><span>Login</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<!-- login area end -->

@endsection



                                   