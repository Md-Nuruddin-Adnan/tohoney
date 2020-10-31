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
      <a class="breadcrumb-item" href="{{ route('blog.index') }}">Blog</a>
      <span class="breadcrumb-item active">{{ $blog_info->blog_title }}</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Blog Edit</h5>
            <p>This is Blog Edit Page</p>
        </div><!-- sl-page-title -->
    <!-- ########## START CODE HERE ########## -->
    <div class="row">
      <div class="col-md-6 m-auto">
        <div class="card">
          <div class="card-header card-header-default">Edit Blog</div>
          <div class="card-body">
            @if (session('blog_success'))
              <div class="alert alert-success">{{ session('blog_success') }}</div>
            @endif
            <form action="{{ route('blog.update', $blog_info->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PATCH')
              <div class="form-group">
                <label>Blog Title</label>
                <select name="category_id" class="form-control">
                  <option value="">--Select a category--</option>
                  @foreach ($blog_categories as $blog_category)
                    <option {{ ($blog_category->id == $blog_info->category_id) ? "selected":"" }}  value="{{ $blog_category->id }}">{{ $blog_category->category_name }}</option>
                      {{-- <option value="{{ $blog_category->id }}">{{ $blog_category->category_name }}</option> --}}
                  @endforeach
                </select>
                @error('category_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label>Blog Title</label>
                <input type="text" name="blog_title" class="form-control" value="{{ $blog_info->blog_title }}">
                @error('blog_title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label>Blog Description</label>
                <textarea name="blog_description" id="blog_description" class="form-control" rows="4">{{ $blog_info->blog_description }}</textarea>
                @error('blog_description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label>Blog Thumbnail Photo (500x360)</label>
                <div class="show-image mt-3">
                  <img class="img-fluid" id="tenant_photo_viewer" src="{{ asset('uploads/blog_thumbnail_photos') }}/{{ $blog_info->blog_thumbnail_photo }}" alt="your image"/>
                  <script>
                    function readURL_1(input) {
                      if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                          $('#tenant_photo_viewer').attr('src', e.target.result);
                        };
                        $('#tenant_photo_viewer').removeClass('d-none');
                        reader.readAsDataURL(input.files[0]);
                      }
                    }
                  </script>
                </div>
                <input type="file" name="blog_thumbnail_photo" class="form-control" onchange="readURL_1(this)">
                @error('blog_thumbnail_photo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label>Blog Details Photo (870x500)</label>
                <div class="show-image mt-3">
                  <img class="img-fluid" id="tenant_photo_viewer_2" src="{{ asset('uploads/blog_details_photos') }}/{{ $blog_info->blog_details_photo }}" alt="your image"/>
                  <script>
                    function readURL_2(input) {
                      if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                          $('#tenant_photo_viewer_2').attr('src', e.target.result);
                        };
                        $('#tenant_photo_viewer_2').removeClass('d-none');
                        reader.readAsDataURL(input.files[0]);
                      }
                    }
                  </script>
                </div>
                <input type="file" name="blog_details_photo" class="form-control"  onchange="readURL_2(this)">
                @error('blog_details_photo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-success btn-block">Update</button>
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
    