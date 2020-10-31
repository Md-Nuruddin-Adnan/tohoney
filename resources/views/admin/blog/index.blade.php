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
      <span class="breadcrumb-item active">Blog </span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Blog</h5>
            <p>This is Blog Page</p>
        </div><!-- sl-page-title -->
    <!-- ########## START CODE HERE ########## -->
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header card-header-default">
            Blog
          </div>
          <div class="card-body">
            @if (session('delete_status'))
              <div class="alert alert-danger">{{ session('delete_status') }}</div>
            @endif
            @if (session('edit_success'))
              <div class="alert alert-warning">{{ session('edit_success') }}</div>
            @endif
            <div class="teble-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Sl. NO</th>
                    <th>Blog Category</th>
                    <th>Blog Title</th>
                    <th>Description</th>
                    <th>Blog Thumbnail Photo</th>
                    <th>Created</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($blogs as $blog)
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $blog->blog_category->category_name }}</td>
                    <td>{{ $blog->blog_title }}</td>
                    <td>{!! $blog->blog_description !!}</td>
                    <td>
                      <img src="{{ asset('uploads/blog_thumbnail_photos') }}/{{ $blog->blog_thumbnail_photo }}" alt="no image" style="width: 100px">
                    </td>
                    <td>
                      <ul>
                        <li>{{ $blog->user->name }}</li>
                        <li>{{ $blog->created_at->diffForHumans() }}</li>
                      </ul>
                    </td>
                    <td>
                      <div class="btn-group">
                        <a href="{{ route('blog.edit', $blog->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{ route('blog.delete', $blog->id) }}" class="btn btn-sm btn-danger">Delete</a>
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
          <div class="card-header card-header-default">Add New Blog</div>
          <div class="card-body">
            @if (session('blog_success'))
              <div class="alert alert-success">{{ session('blog_success') }}</div>
            @endif
            <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <label>Blog Title</label>
                <select name="category_id" class="form-control">
                  <option value="">--Select a category--</option>
                  @foreach ($blog_categories as $blog_category)
                      <option value="{{ $blog_category->id }}">{{ $blog_category->category_name }}</option>
                  @endforeach
                </select>
                @error('category_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label>Blog Title</label>
                <input type="text" name="blog_title" class="form-control" value="{{ old('blog_title') }}">
                @error('blog_title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label>Blog Description</label>
                <textarea name="blog_description" id="blog_description" class="form-control" rows="4">{{ old('blog_description') }}</textarea>
                @error('blog_description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label>Blog Thumbnail Photo (500x360)</label>
                <input type="file" name="blog_thumbnail_photo" class="form-control">
                @error('blog_thumbnail_photo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label>Blog Details Photo (870x500)</label>
                <input type="file" name="blog_details_photo" class="form-control">
                @error('blog_details_photo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-success btn-block">Add Blog</button>
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
@section('footer_script')
<script>
   $(function(){
    'use strict';

    // Summernote editor
    $('#blog_description').summernote({
      height: 150,
      tooltip: false
    })

  })
</script>
@endsection
    