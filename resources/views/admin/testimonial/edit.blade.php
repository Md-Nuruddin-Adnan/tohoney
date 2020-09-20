@extends('layouts.dashboard_app')

@section('title')
    Testimonial
@endsection

@section('testimonial')
  active
@endsection

@section('dashboard_content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
        <a class="breadcrumb-item" href="{{ route('testimonial.index') }}">Testimonial</a>
        <span class="breadcrumb-item active">{{ $testimonial_info->name }}</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
        <h5>Testimonial Edit</h5>
        <p>This is a Testimonial edit page</p>
        </div><!-- sl-page-title -->
        <!-- ########## START CODE HERE ########## -->

        <div class="row">
          <div class="col-lg-6 m-auto">
            <div class="card">
              <div class="card-header card-header-default">Edit Testimonial</div>
              <div class="card-body">
                {{-- @if (session('testimonial_success_status'))
                  <div class="alert alert-success">{{ session('testimonial_success_status') }}</div>
                @endif --}}
                <form action="{{ route('testimonial.update', $testimonial_info->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PATCH')
                  <div class="form-group">
                    <label>Client Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ $testimonial_info->name }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Client Designation</label>
                    <input type="text" name="designation" class="form-control" placeholder="Enter Clint Designation" value="{{ $testimonial_info->designation }}">
                    @error('designation')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <textarea name="message" rows="4" class="form-control" placeholder="Enter Client Message">{{ $testimonial_info->message }}</textarea>
                    @error('message')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Testimonial Photo</label>
                    <input type="file" name="testimonial_photo" class="form-control" onchange="readURL(this)">
                    @error('testimonial_photo')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="show-image mt-3">
                      <img class="img-fluid" id="tenant_photo_viewer" src="{{ asset('uploads/testimonial_photos') }}/{{ $testimonial_info->testimonial_photo }}" alt="your image"/>
                      <script>
                        function readURL(input) {
                          if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                              $('#tenant_photo_viewer').attr('src', e.target.result).width(200);
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
