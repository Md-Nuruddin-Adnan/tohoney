@extends('layouts.dashboard_app')

@section('title')
  Coupon
@endsection

@section('coupon')
  active
@endsection

@section('dashboard_content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
        <a class="breadcrumb-item" href="{{ route('coupon.index') }}">Coupon</a>
        <span class="breadcrumb-item active">Edit</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
        <h5>Coupon Edit</h5>
        <p>This is a Coupon edit page</p>
        </div><!-- sl-page-title -->
        <!-- ########## START CODE HERE ########## -->
        <div class="row">

          <div class="col-lg-4 m-auto">
            <div class="card">
              <div class="card-header">
                <h4>Edit Coupon</h4>
              </div>
              <div class="card-body">
                @if(session('coupon_status'))
                    <div class="alert alert-success">
                      {{ session('coupon_status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('coupon.update', $coupon_info->id) }}">
                  @csrf
                  @method('PATCH')
                  <div class="form-group">
                    <label for="">Coupon Name</label>
                    <input type="text" name="coupon_name" class="form-control" value="{{ $coupon_info->coupon_name }}">
                    @error('coupon_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Discount Amount</label>
                    <input type="text" name="discount_amount" class="form-control" value="{{ $coupon_info->discount_amount }}">
                    @error('discount_amount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Minimum Purchase Amount</label>
                    <input type="text" name="minimum_purchase_amount" class="form-control" value="{{ $coupon_info->minimum_purchase_amount }}">
                    @error('minimum_purchase_amount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Validity Till</label>
                    <input type="date" name="validity_till" class="form-control" value="{{ $coupon_info->validity_till }}">
                    @error('validity_till')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-success">Update</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        

        <!-- ########## END CODE HERE ########## -->
    </div><!-- sl-pagebody -->
</div><!-- sl-mainpanel -->
<!-- ########## END: MAIN PANEL ########## -->
@endsection
