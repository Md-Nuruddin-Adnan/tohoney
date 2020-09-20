@extends('layouts.dashboard_app')

@section('title')
    Category
@endsection

@section('category')
  active
@endsection

@section('dashboard_content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ url('home') }}">Home</a>
        <span class="breadcrumb-item active">Category</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
        <h5>Category</h5>
        <p>This is a Category page</p>
        </div><!-- sl-page-title -->
        <!-- ########## START CODE HERE ########## -->
        <div class="row">
          <div class="col-xl-9 col-lg-8">
            <div class="card">
              <div class="card-header">
                <h4>List Category(Active)</h4>
                <h3>Total: {{ $categories_count }}</h3>
              </div>
              <div class="card-body">
                @if (session('update_status'))
                  <div class="alert alert-success">
                      {{ session('update_status') }}
                  </div>
                @endif
                @if (session('delete_status'))
                    <div class="alert alert-danger">
                      {{ session('delete_status') }}
                    </div>
                @endif
                @if (session('mark_delete_status'))
                    <div class="alert alert-danger">
                      {{ session('mark_delete_status') }}
                    </div>
                @endif
                <form method="POST" action="{{ url('mark/delete/category') }}">
                  @csrf
                  <div class="table-responsive">
                    <table id="category_table" class="table table-bordered">
                      <thead>
                        <tr class="text-nowrap">
                          <th>Mark</th>
                          <th>Sl. No</th>
                          <th>Category Name</th>
                          <th>Category Description</th>
                          <th>Category Created By</th>
                          <th>Photo</th>
                          <th>Created at</th>
                          <th>Updated at</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($categories as $category)
                        <tr>
                          <td>
                            <input type="checkbox" name="category_id[]" value="{{ $category->id }}">
                          </td>
                          <td>{{ $loop->index + 1 }}</td>
                          <td>{{ $category->category_name }}</td>
                          <td>{{ $category->category_description }}</td>
                          <td>{{ Str::title(App\User::find($category->user_id)->name) }}</td>
                          <td>
                            <img src="{{ asset('uploads/category_photos') }}/{{ $category->category_photo }}" alt="no photo" class="img-fluid">
                          </td>
                          <td class="text-nowrap">
                            <li>{{ $category->created_at->format('d/m/Y h:i:s') }}</li>
                            <li>{{ $category->created_at->diffForHumans() }}</li>
                          </td>
                          <td class="text-nowrap">
                            @isset($category->updated_at)
                            <li>{{ $category->updated_at->format('d/m/Y h:i:s') }}</li>
                            <li>{{ $category->updated_at->diffForHumans() }}</li>
                            @endisset
                          </td>
                          <td>
                            <div class="btn-group">
                              <a href="{{ url('edit/category') }}/{{ $category->id }}" class="btn btn-sm btn-info">Edit</a>
                              <a href="{{ url('delete/category') }}/{{ $category->id }}" class="btn btn-sm btn-danger">Delete</a>
                            </div>
                          </td>
                        </tr>
                        @empty
                          <tr>
                            <td colspan="50" class="text-danger text-center"><h4>No Data Availble</h4></td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                  @if ($categories->count() > 0)
                  <button type="submit" class="btn btn-danger">Mark Delete</button>
                  @endif
                </form>
              </div>
            </div>
  
            {{-- Deleted Categories --}}
            <div class="card mt-5">
              <div class="card-header bg-danger text-white">
                <h4>List Category (Deleted)</h4>
              </div>
              <div class="card-body">
                @if (session('restore_status'))
                    <div class="alert alert-success">
                      {{ session('restore_status') }}
                    </div>
                @endif
                @if (session('forcedelete_status'))
                    <div class="alert alert-danger">
                      {{ session('forcedelete_status') }}
                    </div>
                @endif
                @if (session('mark_restore_status'))
                    <div class="alert alert-success">
                      {{ session('mark_restore_status') }}
                    </div>
                @endif
                <form method="POST" action="{{ url('mark/restore/category') }}">
                  @csrf
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr class="text-nowrap">
                          <th>Mark</th>
                          <th>Sl. No</th>
                          <th>Category Name</th>
                          <th>Category Description</th>
                          <th>Category Created By</th>
                          <th>Photo</th>
                          <th>Created at</th>
                          <th>Updated at</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($deleted_categories as $deleted_category)
                        <tr>
                          <td><input type="checkbox" name="category_id[]" value="{{ $deleted_category->id }}"></td>
                          <td>{{ $loop->index + 1 }}</td>
                          <td>{{ $deleted_category->category_name }}</td>
                          <td>{{ $deleted_category->category_description }}</td>
                          <td>{{ Str::title(App\User::find($deleted_category->user_id)->name) }}</td>
                          <td>
                            <img src="{{ asset('uploads/category_photos') }}/{{ $deleted_category->category_photo }}" alt="no photo" class="img-fluid">
                          </td>
                          <td class="text-nowrap">
                            <li>{{ $deleted_category->created_at->format('d/m/Y h:i:s') }}</li>
                            <li>{{ $deleted_category->created_at->diffForHumans() }}</li>
                          </td>
                          <td class="text-nowrap">
                            <li>{{ $deleted_category->updated_at->format('d/m/Y h:i:s') }}</li>
                            <li>{{ $deleted_category->updated_at->diffForHumans() }}</li>
                          </td>
                          <td>
                            <div class="btn-group">
                              <a href="{{ url('forcedelete/category') }}/{{ $deleted_category->id }}" class="btn btn-sm btn-danger">F.D</a>
                              <a href="{{ url('restore/category') }}/{{ $deleted_category->id }}" class="btn btn-sm btn-success">Restore</a>
                            </div>
                          </td>
                        </tr>
                        @empty
                          <tr>
                            <td colspan="50" class="text-danger text-center"><h4>No Data Availble</h4></td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                  @if ($deleted_categories->count() > 0)
                    <button type="submit" class="btn btn-success">Mark Restore</button>
                  @endif
                </form>
                
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-lg-4 ">
            <div class="card">
              <div class="card-header">
                <h4>Add Category</h4>
              </div>
              <div class="card-body">
                @if (session('success_status'))
                  <div class="alert alert-success">
                      {{ session('success_status') }}
                  </div>
                @endif
                <form method="POST" action="{{ url('add/category/post') }}" enctype="multipart/form-data">
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
                    <label for="">Category Name</label>
                    <input type="text" name="category_name" class="form-control" placeholder="Enter category name" value="{{ old('category_name') }}">
                    @error('category_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Category Description</label>
                    <textarea name="category_description" class="form-control" rows="4">{{ old('category_description') }}</textarea>
                    @error('category_description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Category Photo</label>
                    <input type="file" class="form-control" name="category_photo">
                  </div>
                  <div class="form-group">
                    <button class="btn btn-success">Add Cetegory</button>
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

    $('#category_table').DataTable({
      responsive: false,
      language: {
        searchPlaceholder: 'Search...',
        sSearch: '',
        lengthMenu: '_MENU_ items/page',
      }
    });

  });
</script>
@endsection