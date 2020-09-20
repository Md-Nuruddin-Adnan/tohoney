@extends('layouts.dashboard_app')

@section('title')
    Category Edit
@endsection

@section('category')
  active
@endsection

@section('dashboard_content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
  <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ url('home') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('add/category') }}">Category</a>
      <span class="breadcrumb-item active">Edit</span>
  </nav>

  <div class="sl-pagebody">
      <div class="sl-page-title">
      <h5>Edit Category</h5>
      <p>This is edit category page</p>
      </div><!-- sl-page-title -->
      <!-- ########## START CODE HERE ########## -->
      
      <div class="row">
        <div class="col-lg-4 m-auto">
          <div class="card">
            <div class="card-header card-header-default">
              Edit Category
            </div>
            <div class="card-body">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ url('add/category') }}">Add Category</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{ $category_info->category_name }}</li>
                </ol>
              </nav>
              <form method="POST" action="{{ url('edit/category/post') }}">
                @csrf
                {{-- print all errors --}}
                {{-- @if ($errors->all())
                  <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                  </div>
                @endif --}}
                <div class="form-group">
                  <input type="hidden" name="category_id" value="{{ $category_info->id }}">
                  <label for="">Category Name</label>
                  <input type="text" name="category_name" class="form-control" placeholder="Enter category name" value="{{ $category_info->category_name }}">
                  @error('category_name')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="">Category Description</label>
                  <textarea name="category_description" class="form-control" rows="4">{{ $category_info->category_description }}</textarea>
                  @error('category_description')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="form-group">
                 <button class="btn btn-success">Edit Cetegory</button>
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