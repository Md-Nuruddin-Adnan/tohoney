@extends('layouts.frontend_app')

@section('title')
    Tohoney | Search
@endsection


@section('frontend_content')
    <!-- product-area start -->
    <div class="product-area">
      <div class="fluid-container">
          <div class="row">
              <div class="col-12">
                  <div class="section-title">
                      <h2>Total search Product({{ $search_result->count() }})</h2>
                      <img src="{{ asset('frontend_asset') }}/images/section-title.png" alt="">
                  </div>
              </div>
          </div>
          <ul class="row">
              @forelse ($search_result as $active_product)
              <li class="col-xl-3 col-lg-4 col-sm-6 col-12 moreload">
                  <div class="product-wrap">
                      <div class="product-img">
                          <span>Sale</span>
                          <img src="{{ asset('uploads/product_photos') }}/{{ $active_product->product_thumbnail_photo }}" alt="">
                          <div class="product-icon flex-style">
                              <ul>
                                  <li><a data-toggle="modal" data-target="#exampleModalCenter" href="javascript:void(0);"><i class="fa fa-eye"></i></a></li>
                                  <li><a href="{{ route('wishlist.store', $active_product->id) }}"><i class="fa fa-heart"></i></a></li>
                                  <li><a href="cart.html"><i class="fa fa-shopping-bag"></i></a></li>
                              </ul>
                          </div>
                      </div>
                      <div class="product-content">
                          <h3><a href="{{ url('product/details') }}/{{ $active_product->slug }}">{{ $active_product->product_name }}</a></h3>
                          <p class="pull-left float-left">${{ $active_product->product_price }}</p>
                          <ul class="pull-right float-right d-flex">
                              @if (average_star($active_product->id) == 0)
                                  <i class="far fa-star"></i>
                                  <i class="far fa-star"></i>
                                  <i class="far fa-star"></i>
                                  <i class="far fa-star"></i>
                                  <i class="far fa-star"></i>
                              @else
                                  @for ($i = 1; $i <= average_star($active_product->id); $i++)
                                      <li><i class="fa fa-star"></i></li>
                                  @endfor
                              @endif
                          </ul>
                      </div>
                  </div>
              </li>
              @empty
                  <li class="text-center text-danger">No Product Found</li>
              @endforelse
              <li class="col-12 text-center">
                  <a class="loadmore-btn" href="javascript:void(0);">Load More</a>
              </li>
          </ul>
      </div>
  </div>
  <!-- product-area end -->
@endsection
