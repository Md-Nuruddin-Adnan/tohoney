@extends('layouts.frontend_app')

@section('title')
    Tohoney | Wishlist
@endsection

@section('frontend_content')
 <!-- .breadcumb-area start -->
 <div class="breadcumb-area bg-img-4 ptb-100">
  <div class="container">
      <div class="row">
          <div class="col-12">
              <div class="breadcumb-wrap text-center">
                  <h2>Wishlist</h2>
                  <ul>
                      <li><a href="{{ url('/') }}">Home</a></li>
                      <li><span>Wishlist</span></li>
                  </ul>
              </div>
          </div>
      </div>
  </div>
</div>
<!-- .breadcumb-area end -->
<!-- wishlist-area start -->
<div class="cart-area ptb-100">
  <div class="container">
      <div class="row">
          <div class="col-12">
            <div class="table-responsive">
                  <table class="w-100 cart-wrap">
                      <thead>
                          <tr class="text-nowrap">
                              <th class="images">Image</th>
                              <th class="product">Product</th>
                              <th class="ptice">Price</th>
                              <th class="stock">Stock Stutus </th>
                              <th class="addcart">Add to Cart</th>
                              <th class="remove">Remove</th>
                          </tr>
                      </thead>
                      <tbody>
                          @forelse(wishlist_items() as $wishlist_item)
                            <tr>
                                <td class="images"><img src="{{ asset('uploads/product_photos') }}/{{ $wishlist_item->product->product_thumbnail_photo }}" alt=""></td>
                                <td class="product"><a href="{{ url('product/details') }}/{{ $wishlist_item->product->slug }}">{{ $wishlist_item->product->product_name }}</a></td>
                                <td class="ptice">${{ $wishlist_item->product->product_price }}</td>
                                <td class="stock">
                                  @if ($wishlist_item->product->product_quantity > 0)
                                    In Stock
                                  @endif
                                  @if ($wishlist_item->product->product_quantity == 0)
                                    <span>Out of Stock</span>
                                  @endif
                                </td>
                                <td class="addcart"><a href="{{ url('product/details') }}/{{ $wishlist_item->product->slug }}">Add to Cart</a></td>
                                <td class="remove">
                                  <a href="{{ route('wishlist.remove', $wishlist_item->id) }}"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                          @empty
                            <tr>
                              <td colspan="50" class="text-center text-danger">No Data Found</td>
                            </tr>
                          @endforelse
                      </tbody>
                  </table>
                </div>
          </div>
      </div>
  </div>
</div>
<!-- wishlist-area end -->
@endsection