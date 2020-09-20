@extends('layouts.dashboard_app')

@section('title')
    Product
@endsection

@section('product')
  active
@endsection

@section('dashboard_content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
        <span class="breadcrumb-item active">Product</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
        <h5>Product</h5>
        <p>This is a Product page</p>
        </div><!-- sl-page-title -->
        <!-- ########## START CODE HERE ########## -->
        <div class="row">
          <div class="col-lg-8">
            <div class="card">
              <div class="card-header">
                <h3>Total: {{ $products->count() }}</h3>
              </div>
              <div class="card-body">
                  <div class="table-responsive">
                    <table id="product_table" class="table table-bordered">
                      <thead>
                        <tr class="text-nowrap">
                          <th>Sl. No</th>
                          <th>Category Name</th>
                          <th>Product Name</th>
                          <th>Price</th>
                          <th>Quantity</th>
                          <th>Alert Quantity</th>
                          <th>Photo</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($products as $product)
                        <tr>
                          <td>{{ $loop->index + 1 }}</td>
                          {{-- <td>{{ App\Category::find($product->category_id)->category_name }}</td> --}}
                          <td>{{ $product->productonetoonecategory->category_name }}</td>
                          <td>{{ $product->product_name }}</td>
                          <td>{{ $product->product_price }}</td>
                          <td>{{ $product->product_quantity }}</td>
                          <td>{{ $product->product_alert_quantity }}</td>
                          <td>
                            <img style="max-width: 150px"  class="img-fluid" src="{{ asset('uploads\product_photos') }}/{{ $product->product_thumbnail_photo }}" alt="No Photo">
                          </td>
                          <td>
                            <div class="btn-group">
                              <a href="{{ route('product.edit', $product->id) }}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fas fa-edit"></i></a>
                              <form method="POST" action="{{ route('product.destroy', $product->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                              </form>
                              <button value="{{ route('product_alert_delete', $product->id ) }}" class="btn btn-warning btn_delete" data-toggle="tooltip" data-placement="bottom" title="Alert Delete"><i class="fas fa-exclamation-triangle"></i></button>
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
              </div>
            </div>


            <div class="card">
              <div class="card-header">
                <h3>Total: {{ $deleted_products->count() }}</h3>
              </div>
              <div class="card-body">
                  <div class="table-responsive">
                    <table id="product_table" class="table table-bordered">
                      <thead>
                        <tr class="text-nowrap">
                          <th>Sl. No</th>
                          <th>Category Name</th>
                          <th>Product Name</th>
                          <th>Price</th>
                          <th>Quantity</th>
                          <th>Alert Quantity</th>
                          <th>Photo</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($deleted_products as $deleted_product)
                        <tr>
                          <td>{{ $loop->index + 1 }}</td>
                          {{-- <td>{{ App\Category::find($deleted_product->category_id)->category_name }}</td> --}}
                          <td>{{ $deleted_product->productonetoonecategory->category_name }}</td>
                          <td>{{ $deleted_product->product_name }}</td>
                          <td>{{ $deleted_product->product_price }}</td>
                          <td>{{ $deleted_product->product_quantity }}</td>
                          <td>{{ $deleted_product->product_alert_quantity }}</td>
                          <td>
                            <img style="max-width: 150px"  class="img-fluid" src="{{ asset('uploads\product_photos') }}/{{ $deleted_product->product_thumbnail_photo }}" alt="No Photo">
                          </td>
                          {{-- <td>
                            <div class="btn-group">
                              <a href="{{ route('product.edit', $product->id) }}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fas fa-edit"></i></a>
                              <form method="POST" action="{{ route('product.destroy', $product->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                              </form>
                              <button value="{{ route('product_alert_delete', $product->id ) }}" class="btn btn-warning btn_delete" data-toggle="tooltip" data-placement="bottom" title="Alert Delete"><i class="fas fa-exclamation-triangle"></i></button>
                            </div>
                          </td> --}}
                          <td>
                            <a href="{{ route('product_force_delete', $deleted_product->id) }}" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Force Delete"><i class="fas fa-trash-alt"></i></a>
                            <a href="{{ route('restore_product', $deleted_product->id) }}" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Restore"><i class="fas fa-undo-alt"></i></a>
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
              </div>
            </div>
  
          </div>

          <div class="col-lg-4 ">
            <div class="card">
              <div class="card-header">
                <h4>Add Product</h4>
              </div>
              <div class="card-body">
                @if(session('product_status'))
                    <div class="alert alert-success">
                      {{ session('product_status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label for="">Category Name</label>
                    <select name="category_id" class="form-control">
                      <option value="">--Select One--</option>
                      @foreach ($active_categories as $active_category)
                        <option value="{{ $active_category->id }}">{{ $active_category->category_name }}</option>
                      @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Product Name</label>
                    <input type="text" name="product_name" class="form-control" value="{{ old('product_name') }}">
                    @error('product_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Product Short Description</label>
                    <textarea name="product_short_description" class="form-control" rows="4">{{ old('product_short_description') }}</textarea>
                    @error('product_short_description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Product Long Description</label>
                    <textarea name="product_long_description" id="product_long_description" class="form-control" rows="6">{{ old('product_long_description') }}</textarea>
                    @error('product_long_description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Product Price</label>
                    <input type="text" class="form-control" name="product_price" value="{{ old('product_price') }}">
                    @error('product_price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Product Quantity</label>
                    <input type="text" class="form-control" name="product_quantity" value="{{ old('product_quantity') }}">
                    @error('product_quantity')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Alert Quantity</label>
                    <input type="text" class="form-control" name="product_alert_quantity" value="{{ old('product_alert_quantity') }}">
                    @error('product_alert_quantity')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Product Thumbnial Photo</label>
                    <input type="file" class="form-control" name="product_thumbnail_photo">
                    @error('product_thumbnail_photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Product Multiple Photo</label>
                    <input type="file" class="form-control" name="product_multiple_photo[]" multiple>
                    @error('product_multiple_photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-success">Add Product</button>
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

    $('#product_table').DataTable({
      responsive: false,
      language: {
        searchPlaceholder: 'Search...',
        sSearch: '',
        lengthMenu: '_MENU_ items/page',
      }
    });

    // Sweetalert delete start
    $('#product_table').on('click', '.btn_delete', function(){
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


    //  ClassicEditor
    // .create( document.querySelector( '#product_long_description' ) )
    // .then( editor => {
    //         console.log( editor );
    // } )
    // .catch( error => {
    //         console.error( error );
    // } );

      // Summernote editor
      $('#product_long_description').summernote({
          height: 150,
          tooltip: false
        })

  });
</script>
@endsection