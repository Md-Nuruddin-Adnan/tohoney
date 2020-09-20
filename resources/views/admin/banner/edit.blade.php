@extends('layouts.dashboard_app')

@section('title')
    banner
@endsection

@section('banner')
  active
@endsection

@section('dashboard_content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
        <a class="breadcrumb-item" href="{{ route('banner.index') }}">Banner</a>
        <span class="breadcrumb-item active">{{ $banner_info->banner_title }}</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
        <h5>Banner Edit</h5>
        <p>This is a Banner Edit page</p>
        </div><!-- sl-page-title -->
        <!-- ########## START CODE HERE ########## -->

        <div class="row">

          <div class="col-lg-6 m-auto">
            <div class="card">
              <div class="card-header card-header-default">Edit banner</div>
              <div class="card-body">
                @if (session('banner_success_status'))
                  <div class="alert alert-success">{{ session('banner_success_status') }}</div>
                @endif
                <form action="{{ route('banner.update', $banner_info->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PATCH')
                  <div class="form-group">
                    <label>Banner Title</label>
                    <input type="text" name="banner_title" class="form-control" placeholder="Enter Banner Title" value="{{ $banner_info->banner_title }}">
                    @error('banner_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Banner Description</label>
                    <textarea name="banner_description" class="form-control" placeholder="Enter Banner Description" rows="4">{{ $banner_info->banner_description }}</textarea>
                    @error('banner_description')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Banner Photo</label>
                    <input type="file" name="banner_photo" class="form-control" onchange="readURL(this)">
                    @error('banner_photo')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="show-image mt-3">
                      <img class="img-fluid" id="tenant_photo_viewer" src="{{ asset('uploads/banner_photos') }}/{{ $banner_info->banner_photo }}" alt="your image"/>
                      <script>
                        function readURL(input) {
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
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-info">Submit</button>
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