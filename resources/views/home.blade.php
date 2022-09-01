@extends('layouts.starlight')

@section('active')
active
@endsection

@section('title')
Home
@endsection

@section('content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
<nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="{{url('/home')}}">Home of Fighter(Let's Fight)</a>
      </nav>
        <div class="sl-pagebody">
          <div class="">
          <div class="row justify-content-center">
          <div class="col-md-8">
           <div class="card">
              <div class="card-header"><h2>Welcome To {{$logged_user}}<span class="float-end">Total User:{{$total_user}}</span></h2></div>
                 <div class="card-body">
                   @if (session('status'))
                    <div class="alert alert-success" role="alert">
                         {{ session('status') }}
                         </div>
                          @endif
                         <h3>Users Information Details</h3>
                         <table class="table table-striped">
                         <tr>
                          <th>SL</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Role</th>
                          <th>Created at</th>
                      </tr>
                      @foreach ($all_users as $index=>$user)
                      <tr>
                        <td>{{$all_users->firstitem()+$index}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                           @php
                              if($user->role == 1){
                                   echo 'Admin';
                               }
                              else if($user->role==2) {
                                 echo 'Moderator';
                               }
                              else if($user->role==3) {
                                 echo 'Editor';
                               }
                              else if($user->role==4) {
                                 echo 'Shopkeeper';
                               }
                              else {
                                 echo 'Not Assign';
                                  }
                             @endphp
                        </td>
                        <td>{{($user->created_at->diffforHumans() > 24)?$user->created_at->format('d/m/y h:i:s A')
                        :$user->created_at->diffforHumans()}}</td>
                    </tr>
                    @endforeach
                   </table>
                   {{$all_users->links()}}
                </div>
            </div>
        </div>
        <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3>Add User</h3>
                        </div>
                        <div class="card-body">
                             <form action="{{ url('/add/users') }}" method="POST">
                                 @csrf
                                 <div class="form-group">
                                     <label for="" class="control-label">Name</label>
                                     <input type="text" class="form-control" name="name" placeholder="Enter Your Name">
                                 </div>
                                 <div class="form-group">
                                     <label for="">Email</label>
                                     <input type="text" class="form-control" name="email" placeholder="Enter Your Email">
                                 </div>
                                 <div class="form-group">
                                     <label for="">Password</label>
                                     <input type="password" class="form-control" name="password" placeholder="Enter Your Password">
                                 </div>
                                 <div class="form-group">
                                     <select class="form-control" name="role" id="">
                                        <option value="">--Select Role--</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Moderator</option>
                                        <option value="3">Editor</option>
                                        <option value="4">Shopkeeper</option>
                                     </select>
                                 </div>
                                 <div class="form-group text-center">
                                     <button class="btn btn-primary "type="submit"> Add User </button>
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
