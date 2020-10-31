@extends('layouts.dashboard_app')

@section('title')
  Coupon
@endsection

@section('order')
  active
@endsection



@section('dashboard_content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
        <span class="breadcrumb-item active">Orders</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
        <h5>Order</h5>
        <p>This is a Order page</p>
        </div><!-- sl-page-title -->
        <!-- ########## START CODE HERE ########## -->
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3>Total: {{ $orders->count() }}</h3>
              </div>
              <div class="card-body">
                  <div class="table-responsive">
                    <table id="order_table" class="table table-bordered">
                      <thead>
                        <tr>
                          <td class="bg-dark text-white">SL. NO</td>
                          <td class="bg-dark text-white">ORDER ID</td>
                          <td class="bg-dark text-white">ORDER BY</td>
                          <td class="bg-dark text-white">DATE</td>
                          <td class="bg-dark text-white">Product Name</td>
                          <td class="bg-dark text-white">PAYMENT METHOD</td>
                          <td class="bg-dark text-white">STATUS</td>
                          <td class="bg-dark text-white">TOTAL</td>
                          <td class="bg-dark text-white">ACTION</td>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($orders as $order)
                        <tr style="background-color: #e9ecef">
                          <td>{{ $loop->index + 1 }}</td>
                          <td>#{{ $order->id }}</td>
                          <td>{{ $order->user->name }}</td>
                          <td>{{ $order->created_at }}</td>
                          <td>
                            <ul>
                              @foreach ($order->order_detail as $order_product)
                                <li>{{ $order_product->product->product_name }} x {{ $order_product->product_quantity }}</li>
                              @endforeach
                            </ul>
                          </td>
                          <td>
                            @if ($order->payment_option == 1)
                                Cash on delivery
                            @else
                                Card
                            @endif
                          </td>
                          <td>
                            <div class="btn-group">
                              <!-- Payment status start -->
                              @if ($order->payment_status == 1)
                                <span style="border-top-right-radius: 0; border-bottom-right-radius: 0" class="badge badge-warning btn-sm">Unpaid</span>
                              @elseif ($order->payment_status == 3)
                                <span style="border-top-right-radius: 0; border-bottom-right-radius: 0" class="badge badge-secondary btn-sm">Refund</span>
                              @else
                                <span style="border-top-right-radius: 0; border-bottom-right-radius: 0" class="badge badge-success">Paid</span>
                              @endif
                              <!-- Payment status end -->
                              <!-- Order status start -->
                              @if ($order->order_status == 1)
                                <span style="border-top-left-radius: 0; border-bottom-left-radius: 0" class="badge badge-dark btn-sm">Processing</span>
                              @elseif($order->order_status == 2)
                                <span style="border-top-left-radius: 0; border-bottom-left-radius: 0" class="badge badge-info btn-sm">Picked</span>
                              @elseif($order->order_status == 3)
                                <span style="border-top-left-radius: 0; border-bottom-left-radius: 0" class="badge badge-primary btn-sm">Shipped</span>
                              @elseif($order->order_status == 4)
                                <span style="border-top-left-radius: 0; border-bottom-left-radius: 0" class="badge badge-success btn-sm">Delivered</span>
                              @elseif($order->order_status == 5)
                                <span style="border-top-left-radius: 0; border-bottom-left-radius: 0" class="badge badge-danger btn-sm">Cencel</span>
                              @endif
                              <!-- Order status end -->
                            </div>
                          </td>
                          <td>${{ $order->total }}</td>
                          <td>
                            <div class="btn-group">
                              @if ($order->payment_status == 1 && $order->order_status != 5)
                              <form id="payment_update_form" action="{{ route('order.update', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success btn_paid btn-sm">Paid</button>
                              </form>
                              @endif
                              <button type="button" class="btn btn-danger btn_delete btn-sm" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Cancel Order" value="{{ route('order.cancel', $order->id) }}">Cencel</button>
                            </div>
                          </td>
                        </tr>
                        @empty
                            <tr>
                              <td class="text-center text-danger" colspan="50">No data found</td>
                            </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
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

    $('#order_table').DataTable({
      responsive: false,
      language: {
        searchPlaceholder: 'Search...',
        sSearch: '',
        lengthMenu: '_MENU_ items/page',
      }
    });

    // Sweetalert delete start
    $('#order_table').on('click', '.btn_delete', function(){
      Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Cancel it!'
    }).then((result) => {
        if (result.value) {
        var delete_link = $(this).val();
        window.location.href = delete_link;
        }
      })
    })

  });
</script>
@endsection