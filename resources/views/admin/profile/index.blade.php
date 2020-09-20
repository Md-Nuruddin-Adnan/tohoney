@extends('layouts.dashboard_app')

@section('title')
    Profile
@endsection

@section('dashboard_content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
  <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ url('home') }}">Home</a>
      <span class="breadcrumb-item active">Profile</span>
  </nav>

  <div class="sl-pagebody">
      <div class="sl-page-title">
      <h5>Profile</h5>
      <p>This is your profile page</p>
      </div><!-- sl-page-title -->
      <!-- ########## START CODE HERE ########## -->

      <div class="container-fluid"> 
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header card-header-default">
                Name Edit 
              </div>
              <div class="card-body">
                @if (session('name_change_status'))
                    <div class="alert alert-success">
                      {{ session('name_change_status') }}
                    </div>
                @endif
                @if (session('name_error'))
                  <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="d-flex align-items-center justify-content-start">
                      <i class="icon ion-ios-close alert-icon tx-24"></i>
                      <span>{{ session('name_error') }}</span>
                    </div><!-- d-flex -->
                  </div><!-- alert -->
                @endif
                <form method="POST" action="{{ url('edit/profile/post') }}">
                  @csrf
                  <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ Auth::user()->name }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                   <button type="submit" class="btn btn-warning">Edit Name</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card">
              <div class="card-header card-header-default">
                Profile Photo Edit
              </div>
              <div class="card-body">
                @error('profile_photo')
                  <div class="alert alert-danger">
                    {{ $message }}
                  </div>
                @enderror
                <form method="POST" action="{{ url('change/profile/photo') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label for="">Profile Photo</label>
                    <input type="file" name="profile_photo" class="form-control" onchange="readURL(this)">
                  </div>
                  <div class="show-image">
                    <img class="d-none" id="tenant_photo_viewer" src="#" alt="your image"/>
                    <script>
                      function readURL(input) {
                        if (input.files && input.files[0]) {
                          var reader = new FileReader();
                          reader.onload = function (e) {
                            $('#tenant_photo_viewer').attr('src', e.target.result).width(150).height(195);
                          };
                          $('#tenant_photo_viewer').removeClass('d-none');
                          reader.readAsDataURL(input.files[0]);
                        }
                      }
                    </script>
                  </div>
                  <div class="form-group">
                   <button type="submit" class="btn btn-primary">Change Profile Photo</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="col-xl-4 col-md-6 m-auto">
            <div class="card mt-4">
              <div class="card-header card-header-default">
                Password Edit
              </div>
              <div class="card-body">
                @if (session('password_change_status'))
                    <div class="alert alert-success">
                      {{ session('password_change_status') }}
                    </div>
                @endif
                @if (session('password_error'))
                    <div class="alert alert-danger">
                      {{ session('password_error') }}
                    </div>
                @endif
                @error('old_password')
                  <div class="alert alert-danger">
                    {{ $message }}
                  </div>
                @enderror
                @error('password')
                  <div class="alert alert-danger">
                    {{ $message }}
                  </div>
                @enderror
                @error('password_confirmation')
                  <div class="alert alert-danger">
                    {{ $message }}
                  </div>
                @enderror
                <form method="POST" action="{{ url('edit/password/post') }}">
                  @csrf
                  <div class="form-group">
                    <label for="">Old Password</label>
                    <div class="input-group">
                      <input type="password" name="old_password" class="form-control" placeholder="Enter Old Password" id="old_password">
                      <div class="input-group-append">
                        <button onmousedown="showOldPassword()" id="old_password_btn" class="btn btn-secondary" type="button">Show</button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="">New Password</label>
                    <div class="input-group">
                      <input type="password" name="password" class="form-control" placeholder="Enter New Password" id="password">
                      <div class="input-group-append">
                        <button onmousedown="showPassword()" id="password_btn" class="btn btn-secondary" type="button">Show</button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="">Confirm Password</label>
                    <div class="input-group">
                      <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" id="password_confirmation">
                      <div class="input-group-append">
                        <button onmousedown="showConfirmPassword()" id="password_confirmation_btn" class="btn btn-secondary" type="button">Show</button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                  <button type="submit" class="btn btn-warning">Change Password</button>
                  </div>
                  <script>
                    function showOldPassword() {
                      var x = document.getElementById("old_password");
                      var y = document.getElementById("old_password_btn");
                      if (x.type === "password") {
                        x.type = "text";
                      } else {
                        x.type = "password";
                      }
                      if (y.innerHTML === "Show") {
                        y.innerHTML = "Hide";
                      } else {
                        y.innerHTML = "Show";
                      }
                    }
                    function showPassword() {
                      var x = document.getElementById("password");
                      var y = document.getElementById("password_btn");
                      if (x.type === "password") {
                        x.type = "text";
                      } else {
                        x.type = "password";
                      }
                      if (y.innerHTML === "Show") {
                        y.innerHTML = "Hide";
                      } else {
                        y.innerHTML = "Show";
                      }
                    }
                    function showConfirmPassword() {
                      var x = document.getElementById("password_confirmation");
                      var y = document.getElementById("password_confirmation_btn");
                      if (x.type === "password") {
                        x.type = "text";
                      } else {
                        x.type = "password";
                      }
                      if (y.innerHTML === "Show") {
                        y.innerHTML = "Hide";
                      } else {
                        y.innerHTML = "Show";
                      }
                    }
                  </script>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ########## END CODE HERE ########## -->
  </div><!-- sl-pagebody -->
</div><!-- sl-mainpanel -->
<!-- ########## END: MAIN PANEL ########## -->
@endsection