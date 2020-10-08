@extends('layouts.frontend_app')

@section('title')
    Tohoney | Checkout
@endsection

@section('frontend_content')
<!-- .breadcumb-area start -->
<div class="breadcumb-area bg-img-4 ptb-100">
  <div class="container">
      <div class="row">
          <div class="col-12">
              <div class="breadcumb-wrap text-center">
                  <h2>Checkout</h2>
                  <ul>
                      <li><a href="index.html">Home</a></li>
                      <li><span>Checkout</span></li>
                  </ul>
              </div>
          </div>
      </div>
  </div>
</div>
<!-- .breadcumb-area end -->
<!-- checkout-area start -->
<div class="checkout-area ptb-100">
  <div class="container">
      <div class="row">
          <div class="col-lg-8">
              <div class="checkout-form form-style">
                  <h3>Billing Details</h3>
                  <form action="{{ route('checkout.post') }}" method="POST">
                      @csrf
                      <div class="row">
                          <div class="col-12">
                              <p>Name *</p>
                              <input type="text" value="{{ Auth::user()->name }}" name="name">
                              @error('name')
                                <div class="text-danger" style="margin-top: -25px; margin-bottom: 25px">
                                  {{ $message }}
                                </div>
                              @enderror
                          </div>
                          <div class="col-sm-6 col-12">
                              <p>Email Address *</p>
                              <input type="text" value="{{ Auth::user()->email }}" name="email">
                              @error('email')
                                <div class="text-danger" style="margin-top: -25px; margin-bottom: 25px">
                                    {{ $message }}
                                </div>
                              @enderror
                          </div>
                          <div class="col-sm-6 col-12">
                              <p>Phone No *</p>
                              <input type="text" name="phone_number" value="{{ old('phone_number') }}">
                              @error('phone_number')
                                <div class="text-danger" style="margin-top: -25px; margin-bottom: 25px">
                                    {{ $message }}
                                </div>
                              @enderror
                          </div>
                          <div class="col-sm-6 col-12">
                              <p>Country *</p>
                              <select id="country_list_1" name="country_id" required>
                                  <option value="">Select a country</option>
                                  @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                  @endforeach
                              </select>
                              @error('country_id')
                                <div class="text-danger" style="margin-top: -25px; margin-bottom: 25px">
                                    {{ $message }}
                                </div>
                              @enderror
                          </div>
                          <div class="col-sm-6 col-12">
                              <p>City *</p>
                              <select id="city_list_1" name="city_id" required>
                                  <option value="">Select a City</option>
                              </select>
                              @error('city_id')
                                <div class="text-danger" style="margin-top: -25px; margin-bottom: 25px">
                                    {{ $message }}
                                </div>
                              @enderror
                          </div>
                          <div class="col-12">
                              <p>Your Address *</p>
                              <input type="text" name="address" value="{{ old('address') }}">
                              @error('address')
                                <div class="text-danger" style="margin-top: -25px; margin-bottom: 25px">
                                    {{ $message }}
                                </div>
                              @enderror
                          </div>

                          <div class="col-12">
                              <input id="toggle2" type="checkbox" value="1" name="shipping_address_status">
                              <label class="fontsize" for="toggle2">Ship to a different address?</label>
                              <div class="row" id="open2">
                                <div class="col-12">
                                    <p>Name *</p>
                                    <input type="text" name="shipping_name" value="{{ old('shipping_name') }}">
                                    @error('shipping_name')
                                      <div class="text-danger" style="margin-top: -25px; margin-bottom: 25px">
                                        {{ $message }}
                                      </div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <p>Email Address *</p>
                                    <input type="text" name="shipping_email" value="{{ old('shipping_email') }}">
                                    @error('shipping_email')
                                      <div class="text-danger" style="margin-top: -25px; margin-bottom: 25px">
                                        {{ $message }}
                                      </div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <p>Phone No *</p>
                                    <input type="text" name="shipping_phone_number" value="{{ old('shipping_phone_number') }}">
                                    @error('shipping_phone_number')
                                      <div class="text-danger" style="margin-top: -25px; margin-bottom: 25px">
                                        {{ $message }}
                                      </div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <p>Country *</p>
                                    <select id="country_list_2" name="shipping_country_id" style="width: 100%; height: 40px; border: 1px solid #d7d7d7; margin-bottom: 25px; padding-left: 20px;">
                                        <option value="">Select a country</option>
                                        @foreach ($countries as $country)
                                          <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select> 
                                     @error('shipping_country_id')
                                         <div class="text-danger" style="margin-top: -25px; margin-bottom: 25px">
                                            {{ $message }}
                                         </div>
                                     @enderror
                                </div>
                                <div class="col-12">
                                    <p>City *</p>
                                    <select id="city_list_2" name="shipping_city_id" style="width: 100%; height: 40px; border: 1px solid #d7d7d7; margin-bottom: 25px; padding-left: 20px;">
                                        <option value="">Select a City</option>
                                    </select>
                                    @error('shipping_city_id')
                                        <div class="text-danger" style="margin-top: -25px; margin-bottom: 25px">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <p>Your Address *</p>
                                    <input type="text" name="shipping_address">
                                    @error('shipping_address')
                                        <div class="text-danger" style="margin-top: -25px; margin-bottom: 25px">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                              </div>
                          </div>
                          <div class="col-12">
                              <p>Order Notes </p>
                              <textarea name="notes" placeholder="Notes about Your Order, e.g.Special Note for Delivery">{{ old('notes') }}</textarea>
                              @error('notes')
                                <div class="text-danger" style="margin-top: -25px; margin-bottom: 25px">
                                    {{ $message }}
                                </div>
                              @enderror
                          </div>
                      </div>
                  
              </div>
          </div>
          <div class="col-lg-4">
              <div class="order-area">
                  <h3>Your Order</h3>
                  <ul class="total-cost">
                    @foreach (cart_items() as $cart_item)
                      <li>{{ $cart_item->product->product_name }} x {{ $cart_item->product_quantity }}<span class="pull-right">${{ $cart_item->product->product_price *$cart_item->product_quantity }}</span></li>
                    @endforeach
                      <li>Subtotal <span class="pull-right"><strong>${{ session('cart_sub_total') }}</strong></span></li>
                      <li>Discount({{ session('coupon_name') }}) <span class="pull-right"><strong>${{ session('discount_amount') }}</strong></span></li>
                      <li>Shipping <span class="pull-right">Free</span></li>
                      <li>Total<span class="pull-right">${{ session('cart_sub_total') - session('discount_amount') }}</span></li>
                  </ul>
                  <ul class="payment-method">
                      <li>
                          <input id="delivery" type="radio" name="payment_option" value="1" checked>
                          <label for="delivery">Cash on Delivery</label>
                      </li>
                      <li>
                          <input id="card" type="radio" value="2" name="payment_option">
                          <label for="card">Credit Card</label>
                      </li>
                  </ul>
                  <button type="submit">Place Order</button>
                </form>
              </div>
          </div>
      </div>
  </div>
</div>
<!-- checkout-area end -->
@endsection

@section('footer_script')
<script>
    $(document).ready(function(){
        $('#country_list_1').select2();
        $('#city_list_1').select2();
        $('#country_list_2').select2();
        $('#city_list_2').select2();
        
        $('#country_list_1').change(function(){
            var country_id = $(this).val();
            // ajax setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // ajax response start
            $.ajax({
                type : 'POST',
                url : 'get/city/list/ajax',
                data : {country_id:country_id},
                success : function(data){
                    $('#city_list_1').html(data);
                }
            });
            // ajax response end
        });
        $('#country_list_2').change(function(){
            var country_id = $(this).val();
            // ajax setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // ajax response start
            $.ajax({
                type : 'POST',
                url : 'get/city/list/ajax',
                data : {country_id:country_id},
                success : function(data){
                    $('#city_list_2').html(data);
                }
            });
            // ajax response end
        });
    })
</script>
@endsection