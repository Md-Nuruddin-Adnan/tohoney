@extends('layouts.frontend_app')

@section('title')
    Tohoney | Cart
@endsection


@section('frontend_content')
<!-- .breadcumb-area start -->
<div class="breadcumb-area bg-img-4 ptb-100">
  <div class="container">
      <div class="row">
          <div class="col-12">
              <div class="breadcumb-wrap text-center">
                  <h2>Shopping Cart</h2>
                  <ul>
                      <li><a href="index.html">Home</a></li>
                      <li><span>Shopping Cart</span></li>
                  </ul>
              </div>
          </div>
      </div>
  </div>
</div>
<!-- .breadcumb-area end -->

<!-- cart-area start -->
<div class="cart-area ptb-100">
  <div class="container">
      <div class="row">
          <div class="col-12">
              @if (session('remove_status'))
                  <div class="alert alert-danger">
                      {{ session('remove_status') }}
                  </div>
              @endif
              @if (session('success'))
                  <div class="alert alert-success">
                      {{ session('success') }}
                  </div>
              @endif
              @if (session('update_status'))
                  <div class="alert alert-success">
                      {{ session('update_status') }}
                  </div>
              @endif
              @if (session('update_error_status'))
                  <div class="alert alert-danger">
                      {{ session('update_error_status') }}
                  </div>
              @endif
              @if ($error_message != '')
                  <div class="alert alert-danger">
                      {{ $error_message }}
                  </div>
              @endif
              <form action="{{ route('cart.update') }}" method="POST">
                  @csrf
                  <div class="table-responsive">
                    <table class="cart-wrap w-100">
                        <thead>
                            <tr>
                                <th class="images">Image</th>
                                <th class="product">Product</th>
                                <th class="ptice">Price</th>
                                <th class="quantity">Quantity</th>
                                <th class="total">Total</th>
                                <th class="remove">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                          @php
                              $cart_sub_total = 0;
                              $flag = 0;
                          @endphp
                          @forelse (cart_items() as $cart_item)
                            <tr class="{{ ($cart_item->product->product_quantity <  $cart_item->product_quantity) ? 'bg-danger text-white':'' }}">
                                <td class="images"><img src="{{ asset('uploads/product_photos') }}/{{ $cart_item->product->product_thumbnail_photo }}" alt=""></td>
                                <td class="product">
                                    <a href="{{ url('product/details') }}/{{ $cart_item->product->slug }}">{{ $cart_item->product->product_name }}</a>
                                    <br>
                                    @if ($cart_item->product->product_quantity <  $cart_item->product_quantity)
                                        Availble Quantity: {{ $cart_item->product->product_quantity }}
                                        @php
                                            $flag = 1 
                                        @endphp
                                    @endif
                                </td>
                                <td class="ptice">${{ $cart_item->product->product_price }}</td>
                                <td class="quantity cart-plus-minus">
                                    <input type="text" value="{{ $cart_item->product_quantity }}" name="cart_info[{{ $cart_item->id }}]" >
                                </td>
                                <td class="total">${{ $cart_item->product->product_price * $cart_item->product_quantity }}</td>
                                <td class="remove">
                                    <a href="{{ route('cart.remove', $cart_item->id) }}"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                            @php
                                $cart_sub_total += $cart_item->product->product_price * $cart_item->product_quantity;
                            @endphp
                            @empty
                                <tr>
                                  <td colspan="50" class="text-center text-danger"> No Product to show</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                  </div>
                  <div class="row mt-60">
                      <div class="col-xl-4 col-lg-5 col-md-6 ">
                          <div class="cartcupon-wrap">
                              <ul class="d-flex">
                                  <li>
                                      <button type="submit">Update Cart</button>
                                  </li>
                                </form>
                                  <li><a href="{{ route('shop') }}">Continue Shopping</a></li>
                              </ul>
                              <h3>Cupon</h3>
                              <p>Enter Your Cupon Code if You Have One</p>
                              <div class="cupon-wrap">
                                  <input type="text" placeholder="Cupon Code" id="apply_coupon_input" value="{{ $coupon_name }}">
                                  <button type="button" id="apply_coupon_btn">Apply Cupon</button>
                              </div>
                              <ul class="my-3">
                                @foreach ($valid_coupons as $valid_coupon)
                                    <li><button type="button" class="badge mb-1 available_coupon_button" value="{{ $valid_coupon->coupon_name }}">{{ $valid_coupon->coupon_name }} - Shop more than or equal ${{  $valid_coupon->minimum_purchase_amount }}</button></li>
                                @endforeach
                              </ul>
                          </div>
                      </div>
                      <div class="col-xl-3 offset-xl-5 col-lg-4 offset-lg-3 col-md-6">
                          <div class="cart-total text-right">
                              <h3>Cart Totals</h3>
                              <ul>
                                  <li><span class="pull-left">Subtotal </span>${{ $cart_sub_total }}</li>
                                  @php
                                    session(['cart_sub_total' => $cart_sub_total]);
                                  @endphp
                                  <li><span class="pull-left">Discount({{ $coupon_name ?: '-' }}) </span>{{ $discount_amount }}%</li>
                                  @php
                                    session(['coupon_name' => $coupon_name ? : '-']);
                                  @endphp
                                  <li><span class="pull-left">Discount Amount </span>${{ ($cart_sub_total * $discount_amount)/100 }}</li>
                                  @php
                                    session(['discount_amount' => (($cart_sub_total * $discount_amount)/100)]);
                                  @endphp
                                  <li><span class="pull-left">Total </span>${{ $cart_sub_total - (($cart_sub_total * $discount_amount)/100) }}</li>
                              </ul>
                              @if ($flag == 1)
                                <a class="text-white">Please solve the issue</a>
                              @elseif(cart_items()->count() < 1) 
                                <a class="text-white">Cart is empty!</a>
                              @else
                                <a href="{{ url('checkout') }}">Proceed to Checkout</a>
                              @endif
                          </div>
                      </div>
                  </div>
          </div>
      </div>
  </div>
</div>
<!-- cart-area end -->

@endsection

@section('footer_script')
    <script>
        $(document).ready(function(){
            $("#apply_coupon_btn").click(function(){
                var apply_coupon_input = $("#apply_coupon_input").val();
                var link_to_go = "{{ url('cart') }}/"+apply_coupon_input;
                window.location.href = link_to_go;
            })

            $(".available_coupon_button").click(function(){
                $("#apply_coupon_input").val($(this).val());
            })
        })
    </script>
@endsection