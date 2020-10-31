@extends('layouts.dashboard_app')

@section('title')
    Product
@endsection

@section('product')
  active
@endsection

@section('dashboard_content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
        <a class="breadcrumb-item" href="{{ route('product.index') }}">Product</a>
        <span class="breadcrumb-item active">{{ $product_info->product_name }}</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
        <h5>Product</h5>
        <p>This is a Product Edit page</p>
        </div><!-- sl-page-title -->
        <!-- ########## START CODE HERE ########## -->
        <div class="row">

          <div class="col-lg-6 m-auto">
            <div class="card">
              <div class="card-header">
                <h4>Edit Product</h4>
              </div>
              <div class="card-body">
                <form method="POST" action="{{ route('product.update', $product_info->id ) }}" enctype="multipart/form-data">
                  @csrf
                  @method('PATCH')
                  <div class="form-group">
                    <label for="">Category Name</label>
                    <select name="category_id" class="form-control">
                      <option value="">--Select One--</option>
                      @foreach ($active_categories as $active_category)
                        <option {{ ($active_category->id == $product_info->category_id) ? "selected":"" }}  value="{{ $active_category->id }}">{{ $active_category->category_name }}</option>
                      @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Product Name</label>
                    <input type="text" name="product_name" class="form-control" value="{{  $product_info->product_name }}">
                    @error('product_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Product Short Description</label>
                    <textarea name="product_short_description" class="form-control" rows="4">{{ $product_info->product_short_description }}</textarea>
                    @error('product_short_description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Product Long Description</label>
                    <textarea id="product_long_description" name="product_long_description" class="form-control" rows="4">{{ $product_info->product_long_description }}</textarea>
                    @error('product_long_description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Product Price</label>
                    <input type="text" class="form-control" name="product_price" value="{{ $product_info->product_price }}">
                    @error('product_price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Product Quantity</label>
                    <input type="text" class="form-control" name="product_quantity" value="{{ $product_info->product_quantity }}">
                    @error('product_quantity')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Alert Quantity</label>
                    <input type="text" class="form-control" name="product_alert_quantity" value="{{ $product_info->product_alert_quantity }}">
                    @error('product_alert_quantity')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-success">Edit Product</button>
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

@section('footer_script')
<script>
  $(function(){
    'use strict';

      // Summernote editor
      $('#product_long_description').summernote({
          height: 150,
          tooltip: false
        })

  });
</script>
@endsection
