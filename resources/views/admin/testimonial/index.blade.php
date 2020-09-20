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
        <span class="breadcrumb-item active">Testimonial</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
        <h5>Testimonial</h5>
        <p>This is a Testimonial page</p>
        </div><!-- sl-page-title -->
        <!-- ########## START CODE HERE ########## -->

        <div class="row">
          <div class="col-lg-8">
            <div class="card">
              <div class="card-header card-header-default">
                Total Client Review: {{ $testimonials->count() }}
              </div>
              <div class="card-body">
                @if (session('Testimonial_delete_status'))
                  <div class="alert alert-danger">{{ session('Testimonial_delete_status') }}</div>
                @endif
                @if (session('mark_delete_status'))
                  <div class="alert alert-danger">{{ session('mark_delete_status') }}</div>
                @endif
                <form action="{{ route('markdeletetestimonial') }}" method="POST" id="mark_delete_form">
                  @csrf
                  <div class="table-responsive">
                    <table class="table" id="testimonial_table">
                      <thead>
                        <tr>
                          <th>
                            <label class="ckbox mg-b-0">
                              <input type="checkbox" id="select-all"><span></span>
                            </label>
                          </th>
                          <th>Sl. No</th>
                          <th>Name</th>
                          <th>Photo</th>
                          <th>Designation</th>
                          <th>Message</th>
                          <th>Created By</th>
                          <th>Created At</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($testimonials as $testimonial)
                        <tr>
                          <td>
                            <label class="ckbox mg-b-0">
                              <input type="checkbox" name="testimonial_id[]" value="{{ $testimonial->id }}" class="testi_id_checkbox"><span></span>
                            </label>
                          </td>
                          <td>{{ $loop->index + 1 }}</td>
                          <td>{{ $testimonial->name }}</td>
                          <td>
                            <img src="{{ asset('uploads/testimonial_photos') }}/{{ $testimonial->testimonial_photo }}" alt="" style="width: 60px" class="img-fluid">
                          </td>
                          <td>{{ $testimonial->designation }}</td>
                          <td>{{ $testimonial->message }}</td>
                          <td>{{ $testimonial->testimonialonetooneuser->name }}</td>
                          <td>{{ $testimonial->created_at->diffForHumans() }}</td>
                          <td>
                            <div class="btn-group">
                              <a href="{{ route('testimonial.edit', $testimonial->id) }}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Edit"><i class="fas fa-edit"></i></a>
                              <button type="button" class="btn btn-danger btn_delete" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Delete" value="{{ route('testimonialdelete', $testimonial->id) }}"><i class="fas fa-trash-alt"></i></button>
                            </div>
                          </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="50" class="text-center text-danger">No Data Foud</td>
                        </tr>
                        @endforelse
                      
                      </tbody>
                    </table>
                  </div>
                </form>
                @if ($testimonials->count() > 0)
                  <button type="submit" class="btn btn-danger" id="mark_delete_btn">Mark Delete</button>
                @endif
              </div>
            </div>
          </div>


          <div class="col-lg-4">
            <div class="card">
              <div class="card-header card-header-default">Add Testimonial</div>
              <div class="card-body">
                @if (session('testimonial_success_status'))
                  <div class="alert alert-success">{{ session('testimonial_success_status') }}</div>
                @endif
                <form action="{{ route('testimonial.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label>Client Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Client Designation</label>
                    <input type="text" name="designation" class="form-control" placeholder="Enter Clint Designation" value="{{ old('designation') }}">
                    @error('designation')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <textarea name="message" rows="4" class="form-control" placeholder="Enter Client Message">{{ old('message') }}</textarea>
                    @error('message')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Testimonial Photo</label>
                    <input type="file" name="testimonial_photo" class="form-control">
                    @error('testimonial_photo')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
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

@section('footer_script')
<script>
  $(function(){
    'use strict';

    // Sweetalert delete start
    $('#testimonial_table').on('click', '.btn_delete', function(){
      Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
        var delete_link = $(this).val();
        window.location.href = delete_link;
        }
      })
    })
    //Sweetalert delete end

    // Sweetalert Mark Delete start
    $("#mark_delete_btn").click(function(){
      Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
          $("#mark_delete_form").submit();
        }
      })
    })
    //Sweetalert Mark Delete end

    // Checkbox all checked
    document.getElementById('select-all').onclick = function() {
      var checkboxes = document.querySelectorAll('#testimonial_table input[type="checkbox"]');
      for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
      }
    }



  });
</script>
@endsection
