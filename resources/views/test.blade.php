@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-6 m-auto">
      <div class="card my-5 bg-dark text-white">
        <div class="card-body">
          <form action="{{ url('test_form_post') }}" method="POST">
            @csrf
            <div class="form-group">
              <label>Name</label>
              <input type="text" name="name" class="form-control" placeholder="" value="{{ old('name') }}">
            </div>
            <div class="form-group">
              <label>Email Address</label>
              <input type="email" name="email" class="form-control" placeholder="">
            </div>
            <div class="form-group">
              <label>Phone Number</label>
              <input type="text" name="phone_number" class="form-control" placeholder="">
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-danger" placeholder="Submit">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection