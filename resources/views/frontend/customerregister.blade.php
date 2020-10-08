@extends('layouts.frontend_app')

@section('title')
    Tohoney | Register
@endsection

@section('frontend_content')
<!-- .breadcumb-area start -->
<div class="breadcumb-area bg-img-4 ptb-100">
  <div class="container">
      <div class="row">
          <div class="col-12">
              <div class="breadcumb-wrap text-center">
                  <h2>Account</h2>
                  <ul>
                      <li><a href="{{ url('/') }}">Home</a></li>
                      <li><span>Register</span></li>
                  </ul>
              </div>
          </div>
      </div>
  </div>
</div>
<!-- .breadcumb-area end -->
<!-- checkout-area start -->
<div class="account-area ptb-100">
  <div class="container">
      <div class="row">
          <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
            <form action="{{ url('customer/register/post') }}" method="POST">
              @csrf
              <div class="account-form form-style">
                  <p>User Name *</p>
                  <input type="text" name="name" value="{{ old('name') }}">
                  @error('name')
                      <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <p>Email Address *</p>
                  <input type="email" name="email" value="{{ old('email') }}">
                  @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <p>Password *</p>
                  <input type="password" name="password" value="{{ old('password') }}">
                  @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <p>Confirm Password *</p>
                  <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}">
                  @error('password_confirmation')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <button type="submit">Register</button>
                  <div class="text-center">
                      <a href="{{ route('login') }}">Or Login</a>
                  </div>
              </div>
            </form>
          </div>
      </div>
  </div>
</div>
<!-- checkout-area end -->
@endsection