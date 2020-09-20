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
        <span class="breadcrumb-item active">Banner</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
        <h5>Banner</h5>
        <p>This is a Banner page</p>
        </div><!-- sl-page-title -->
        <!-- ########## START CODE HERE ########## -->

        <div class="row">
          <div class="col-lg-8">
            <div class="card">
              <div class="card-header card-header-default">
                Total banner : {{ $banners->count() }}
              </div>
              <div class="card-body">
                @if (session('banner_delete_status'))
                  <div class="alert alert-danger">{{ session('banner_delete_status') }}</div>
                @endif
                @if (session('mark_delete_status'))
                  <div class="alert alert-danger">{{ session('mark_delete_status') }}</div>
                @endif
                <form action="{{ route('markdeletebanner') }}" method="POST" id="mark_delete_form">
                  @csrf
                  <div class="table-responsive">
                    <table class="table" id="banner_table">
                      <thead>
                        <tr>
                          <th>
                            <label class="ckbox mg-b-0">
                              <input type="checkbox" id="select-all"><span></span>
                            </label>
                          </th>
                          <th>Sl. No</th>
                          <th>Title</th>
                          <th>Description</th>
                          <th>Photo</th>
                          <th>Created</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($banners as $banner)
                        <tr>
                          <td>
                            <label class="ckbox mg-b-0">
                              <input type="checkbox" name="banner_id[]" value="{{ $banner->id }}" class="banner_id_checkbox"><span></span>
                            </label>
                          </td>
                          <td>{{ $loop->index + 1 }}</td>
                          <td>{{ $banner->banner_title }}</td>
                          <td>{{ $banner->banner_description }}</td>
                          <td>
                            <img src="{{ asset('uploads/banner_photos') }}/{{ $banner->banner_photo }}" alt="" style="width: 400px" class="img-fluid">
                          </td>
                          <td>
                            <li>{{ $banner->banneronetooneuser->name }}</li>
                            <li>{{ $banner->created_at->diffForHumans() }}</li>
                          </td>
                          <td>
                            <div class="btn-group">
                              <a href="{{ route('banner.edit', $banner->id) }}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Edit"><i class="fas fa-edit"></i></a>
                              <button type="button" class="btn btn-danger btn_delete" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Delete" value="{{ route('bannerdelete', $banner->id) }}"><i class="fas fa-trash-alt"></i></button>
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
                @if ($banners->count() > 0)
                  <button type="button" class="btn btn-danger" id="mark_delete_btn">Mark Delete</button>
                @endif
              </div>
            </div>
          </div>


          <div class="col-lg-4">
            <div class="card">
              <div class="card-header card-header-default">Add banner</div>
              <div class="card-body">
                @if (session('banner_success_status'))
                  <div class="alert alert-success">{{ session('banner_success_status') }}</div>
                @endif
                <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label>Banner Title</label>
                    <input type="text" name="banner_title" class="form-control" placeholder="Enter Banner Title" value="{{ old('banner_title') }}">
                    @error('banner_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Banner Description</label>
                    <textarea name="banner_description" class="form-control" placeholder="Enter Banner Description" rows="4">{{ old('banner_description') }}</textarea>
                    @error('banner_description')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Banner Photo</label>
                    <input type="file" name="banner_photo" class="form-control">
                    @error('banner_photo')
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
    $('#banner_table').on('click', '.btn_delete', function(){
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
      var checkboxes = document.querySelectorAll('#banner_table input[type="checkbox"]');
      for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
      }
    }



  });
</script>
@endsection