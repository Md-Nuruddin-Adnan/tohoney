@extends('layouts.dashboard_app')

@section('title')
  Coupon
@endsection

@section('coupon')
  active
@endsection

@section('dashboard_content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
        <span class="breadcrumb-item active">Coupon</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
        <h5>Coupon</h5>
        <p>This is a Coupon page</p>
        </div><!-- sl-page-title -->
        <!-- ########## START CODE HERE ########## -->
        <div class="row">
          <div class="col-lg-8">
            <div class="card">
              <div class="card-header">
                <h3>Total: {{ $coupons->count() }}</h3>
              </div>
              <div class="card-body">
                  <div class="table-responsive">
                    <table id="coupon_table" class="table table-bordered">
                      <thead>
                        <tr class="text-nowrap">
                          <th>Sl. No</th>
                          <th>Coupon Name</th>
                          <th>Discount Amount</th>
                          <th>Minimum Purchase Amount</th>
                          <th>Validity Till</th>
                          <th>Added By</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($coupons as $coupon)
                        <tr>
                          <td>{{ $loop->index + 1 }}</td>
                          <td>{{ $coupon->coupon_name }}</td>
                          <td>{{ $coupon->discount_amount }}</td>
                          <td>{{ $coupon->minimum_purchase_amount }}</td>
                          <td>{{ $coupon->validity_till }}</td>
                          <td>{{ $coupon->user->name }}</td>
                          <td>
                            <div class="btn-group">
                              <a href="{{ route('coupon.edit', $coupon->id) }}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Edit"><i class="fas fa-edit"></i></a>
                              <button type="button" class="btn btn-danger btn_delete" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Delete" value="{{ route('coupon.delete', $coupon->id) }}"><i class="fas fa-trash-alt"></i></button>
                            </div>
                          </td>
                        </tr>
                        @empty
                          <tr>
                            <td colspan="50" class="text-danger text-center"><h4>No Data Available</h4></td>
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
                <h4>Add Coupon</h4>
              </div>
              <div class="card-body">
                @if(session('coupon_status'))
                    <div class="alert alert-success">
                      {{ session('coupon_status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('coupon.store') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label for="">Coupon Name</label>
                    <input type="text" name="coupon_name" class="form-control" value="{{ old('coupon_name') }}">
                    @error('coupon_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Discount Amount</label>
                    <input type="text" name="discount_amount" class="form-control" value="{{ old('discount_amount') }}">
                    @error('discount_amount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Minimum Purchase Amount</label>
                    <input type="text" name="minimum_purchase_amount" class="form-control" value="{{ old('minimum_purchase_amount') }}">
                    @error('minimum_purchase_amount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Validity Till</label>
                    <input type="date" name="validity_till" class="form-control" value="{{ old('validity_till') }}">
                    @error('validity_till')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-success">Add Coupon</button>
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

    $('#coupon_table').DataTable({
      responsive: false,
      language: {
        searchPlaceholder: 'Search...',
        sSearch: '',
        lengthMenu: '_MENU_ items/page',
      }
    });

    // Sweetalert delete start
    $('#coupon_table').on('click', '.btn_delete', function(){
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


  });
</script>
@endsection