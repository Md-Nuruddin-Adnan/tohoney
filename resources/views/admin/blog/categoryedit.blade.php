@extends('layouts.dashboard_app')

@section('title')
    Blog
@endsection

@section('blog')
  active
@endsection

@section('dashboard_content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
      <a class="breadcrumb-item" href="{{ route('blog.category') }}">Blog Category</a>
      <span class="breadcrumb-item active">{{ $category_info->category_name }}</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Blog Category</h5>
            <p>This is Blog Category Page</p>
        </div><!-- sl-page-title -->
    <!-- ########## START CODE HERE ########## -->
    <div class="row">
      <div class="col-md-6 m-auto">
        <div class="card">
          <div class="card-header card-header-default">Edit Blog Category</div>
          <div class="card-body">
            @if (session('category_success'))
              <div class="alert alert-success">{{ session('category_success') }}</div>
            @endif
            <form action="{{ route('blog.category.edit.post') }}" method="POST">
              @csrf
              <div class="form-group">
                <input type="hidden" name="category_id" value="{{ $category_info->id }}">
                <label>Category Name</label>
                <input type="text" name="category_name" class="form-control" value="{{ $category_info->category_name }}">
                @error('category_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label>Category Description</label>
                <textarea name="category_description" class="form-control" rows="4">{{  $category_info->category_description }}</textarea>
                @error('category_description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-warning btn-block">Edit Category</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- ########## END CODE HERE ########## -->
    </div>
</div>
@endsection
    