@extends('layouts.frontend_app')

@section('title')
    Tohoney | Home
@endsection

@section('nav_home')
    active
@endsection

@section('frontend_content')

    <!-- slider-area start -->
    <div class="slider-area">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @forelse ($banners as $banner)
                <div class="swiper-slide overlay">
                    <div class="single-slider slide-inner" style="background-image: url('{{ asset('uploads/banner_photos') }}/{{ $banner->banner_photo }}')">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 col-lg-9 col-12">
                                    <div class="slider-content">
                                        <div class="slider-shape">
                                            <h2 data-swiper-parallax="-500">{{ $banner->banner_title }}</h2>
                                            <p data-swiper-parallax="-400">{{ $banner->banner_description }}</p>
                                            <a href="shop.html" data-swiper-parallax="-300">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                    <h3 class="test-center">No data found</h3>
                @endforelse
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <!-- slider-area end -->

    @include('frontend.includes.featuredarea')


    <!-- start count-down-section -->
    <div class="count-down-area count-down-area-sub">
        <section class="count-down-section section-padding parallax" data-speed="7">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12 text-center">
                        <h2 class="big">Deal Of the Day <span>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin</span></h2>
                    </div>
                    <div class="col-12 col-lg-12 text-center">
                        <div class="count-down-clock text-center">
                            <div id="clock">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
    </div>
    <!-- end count-down-section -->
    <!-- product-area start -->
    <div class="product-area product-area-2">
        <div class="fluid-container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Best Seller</h2>
                        <img src="{{ asset('frontend_asset') }}/images/section-title.png" alt="">
                    </div>
                </div>
            </div>
            <ul class="row">
                @forelse ($best_seller_after_desc as $best_seller)
                <li class="col-xl-3 col-lg-4 col-sm-6 col-12 moreload">
                    <div class="product-wrap">
                        <div class="product-img">
                            @if (App\Product::findOrFail($best_seller->product_id)->product_quantity < 1)
                                <span>Out of Stock</span>
                            @endif
                            <img src="{{ asset('uploads/product_photos') }}/{{ App\Product::findOrFail($best_seller->product_id)->product_thumbnail_photo }}" alt="">
                            <div class="product-icon flex-style">
                                <ul>
                                    <li><a data-toggle="modal" data-target="#exampleModalCenter" href="javascript:void(0);"><i class="fa fa-eye"></i></a></li>
                                    <li><a href="{{ route('wishlist.store', $best_seller->product_id) }}"><i class="fa fa-heart"></i></a></li>
                                    <li><a href="cart.html"><i class="fa fa-shopping-bag"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3><a href="{{ url('product/details') }}/{{ App\Product::findOrFail($best_seller->product_id)->slug }}">{{ App\Product::findOrFail($best_seller->product_id)->product_name }}</a></h3>
                            <p class="pull-left float-left">${{ App\Product::find($best_seller->product_id)->product_price }}</p>
                            <ul class="pull-right float-right d-flex">
                                @if (average_star($best_seller->product_id) == 0)
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                @else
                                    @for ($i = 1; $i <= average_star($best_seller->product_id); $i++)
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
            </ul>
        </div>
    </div>
    <!-- product-area end -->
    <!-- product-area start -->
    <div class="product-area">
        <div class="fluid-container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Our Latest Product</h2>
                        <img src="{{ asset('frontend_asset') }}/images/section-title.png" alt="">
                    </div>
                </div>
            </div>
            <ul class="row">
                @forelse ($active_products as $active_product)
                <li class="col-xl-3 col-lg-4 col-sm-6 col-12 moreload">
                    <div class="product-wrap">
                        <div class="product-img">
                            @if ($active_product->product_quantity < 1)
                                <span>Out of Stock</span>
                            @endif
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
    <!-- testmonial-area start -->
    <div class="testmonial-area testmonial-area2 bg-img-2 black-opacity">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="test-title text-center">
                        <h2>What Our client Says</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 offset-md-1 col-12">
                    <div class="testmonial-active owl-carousel">
                        @forelse ($testimonials as $testimonial)
                            <div class="test-items test-items2">
                                <div class="test-content">
                                    <p>{{ $testimonial->message }}</p>
                                    <h2>{{ $testimonial->name }}</h2>
                                    <p>{{ $testimonial->designation }}</p>
                                </div>
                                <div class="test-img2">
                                    <img src="{{ asset('uploads/testimonial_photos') }}/{{ $testimonial->testimonial_photo }}" alt="">
                                </div>
                            </div>
                        @empty
                            <h4 class="text-center">No Data Found</h4>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- testmonial-area end -->

@endsection
