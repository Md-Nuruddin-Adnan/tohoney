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
      <span class="breadcrumb-item active">Blog Category</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Blog Category</h5>
            <p>This is Blog Category Page</p>
        </div><!-- sl-page-title -->
    <!-- ########## START CODE HERE ########## -->
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header card-header-default">
            Blog Category
          </div>
          <div class="card-body">
            @if (session('category_delete_status'))
              <div class="alert alert-danger">{{ session('category_delete_status') }}</div>
            @endif
            @if (session('category_edit_success'))
              <div class="alert alert-warning">{{ session('category_edit_success') }}</div>
            @endif
            <div class="teble-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Sl. NO</th>
                    <th>Caetgory Name</th>
                    <th>Description</th>
                    <th>Created By</th>
                    <th>Created At</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($blog_categories as $blog_category)
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $blog_category->category_name }}</td>
                    <td>{{ $blog_category->category_description }}</td>
                    <td>{{ $blog_category->user->name }}</td>
                    <td>{{ $blog_category->created_at->diffForHumans() }}</td>
                    <td>
                      <div class="btn-group">
                        <a href="{{ route('blog.category.edit', $blog_category->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{ route('blog.category.delete', $blog_category->id) }}" class="btn btn-sm btn-danger">Delete</a>
                      </div>
                    </td>
                  </tr>
                  @empty
                      <tr>
                        <td colspan="50" class="text-center text-danger">No Data Found</td>
                      </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-header card-header-default">Add New Category</div>
          <div class="card-body">
            @if (session('category_success'))
              <div class="alert alert-success">{{ session('category_success') }}</div>
            @endif
            <form action="{{ route('blog.category.store') }}" method="POST">
              @csrf
              <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="category_name" class="form-control" value="{{ old('category_name') }}">
                @error('category_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label>Category Description</label>
                <textarea name="category_description" class="form-control" rows="4">{{ old('category_description') }}</textarea>
                @error('category_description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <button class="btn btn-success btn-block">Add Category</button>
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
    