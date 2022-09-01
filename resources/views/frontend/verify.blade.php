@extends('frontend.master')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-6 m-auto">
        @if(session('verify'))
          <div class="card">
            <div class="card-header">
               <h3>Email Verify</h3>
          </div>
          <div class="card-body">
              <div class="alert alert-success">{{session('verify')}}</div>
           </div>
         </div>
         @endif
      </div>
  </div>
</div>
@endsection