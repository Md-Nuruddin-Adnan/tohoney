@extends('layouts.dashboard_app')

@section('title')
    Customer | Home
@endsection

@section('customer_home')
  active
@endsection

@section('dashboard_content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
        <span class="breadcrumb-item active">Home</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Customer Dashboard</h5>
          <p>This is a dynamic dashboard</p>
        </div><!-- sl-page-title -->
        <!-- ########## START CODE HERE ########## -->
        <div class="card">
          <div class="card-header card-header-default">
            Order List
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <td>SL. NO</td>
                    <td>DATE</td>
                    <td>PAYMENT METHOD</td>
                    <td>PAYMENT STATUS</td>
                    <td>SUB TOTAL</td>
                    <td>DISCOUNT AMOUNT</td>
                    <td>COUPON NAME</td>
                    <td>TOTAL</td>
                    <td>ACTION</td>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($orders as $order)
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>
                      @if ($order->payment_option == 1)
                          Cash on delivery
                      @else
                          Card
                      @endif
                    </td>
                    <td>
                      @if ($order->payment_status == 1)
                          <div class="badge badge-danger">Unpaid</div>
                      @else
                      <div class="badge badge-success">Paid</div>
                      @endif
                    </td>
                    <td>{{ $order->sub_total }}</td>
                    <td>{{ $order->discount_amount }}</td>
                    <td>{{ $order->coupon_name }}</td>
                    <td>{{ $order->total }}</td>
                    <td>
                      <a href="{{ url('customer/invoice/download') }}/{{ $order->id }}"> <i class="fas fa-download"></i> Download invoice</a>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3">
                      @foreach ($order->order_detail as $order_product)
                        <ul>
                          <li>{{ $order_product->product->product_name }}</li>
                        </ul>
                      @endforeach
                    </td>
                    <td>
                      @if (($order->payment_option == 2) &&  ($order->payment_status == 1))
                          <a href="{{ url('stripe/let') }}/{{ $order->id }}" class="btn btn-sm btn-danger">Make Payment</a>
                      @else

                      @endif
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
        

        <!-- ########## END CODE HERE ########## -->
    </div><!-- sl-pagebody -->
</div><!-- sl-mainpanel -->
<!-- ########## END: MAIN PANEL ########## -->
@endsection