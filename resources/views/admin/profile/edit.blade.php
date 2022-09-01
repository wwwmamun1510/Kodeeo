@extends('layouts.starlight')

@section('content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{url('/home')}}">Home</a>
        <span class="breadcrumb-item active">Edit profile</span>
      </nav>

    <div class="sl-pagebody">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Change Name</h3>
                    </div>
                    @if(session('update_name'))
                        <div class="alert alert-success mt-1">
                            {{session('update_name')}}
                        </div>
                    @endif
                    <div class="card-body">
                        <form action="{{url('/profile/update')}}" method="post">
                            @csrf
                            <div class="mt-3">
                                <label for="" class="form-label">Name</label>
                                <input type="text" value="{{Auth::user()->name}}" name="name" class="form-control">
                            </div>
                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Change Password</h3>
                    </div>
                    @if(session('update'))
                        <div class="alert alert-success mt-1">
                            {{session('update')}}
                        </div>
                    @endif
                    @if(session('old_pass'))
                        <div class="alert alert-danger mt-1">
                            {{session('old_pass')}}
                        </div>
                    @endif
                   
                    <div class="card-body">
                        <form action="{{url('/password/update')}}" method="post">
                            @csrf
                            <div class="mt-3">
                                <label for="" class="form-label">Old Password</label>
                                <input type="password" name="old_password" class="form-control">
                                @error('old_pass')
                                <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <label for="" class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control">
                                @error('password')
                                <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <label for="" class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control">
                                @error('password')
                                <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Change Photo</h3>
                    </div>
                    @if(session('update_photo'))
                        <div class="alert alert-success mt-1">
                            {{session('update_photo')}}
                        </div>
                    @endif
                    <div class="card-body">
                        <form action="{{url('/profile/change')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mt-3">
                                <label for="" class="form-label">Profile Photo</label>
                                <input type="file" name="photo" class="form-control">
                                @error('photo')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
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