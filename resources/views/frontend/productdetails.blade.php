@extends('layouts.frontend_app')

@section('title')
    Tohoney | Product Details
@endsection


@section('frontend_content')
 
 <!-- .breadcumb-area start -->
 <div class="breadcumb-area bg-img-4 ptb-100">
  <div class="container">
      <div class="row">
          <div class="col-12">
              <div class="breadcumb-wrap text-center">
                  <h2>Product Details</h2>
                  <ul>
                      <li><a href="{{ url('/') }}">Home</a></li>
                      <li><span>{{ $product_info->product_name }}</span></li>
                  </ul>
              </div>
          </div>
      </div>
  </div>
</div>
<!-- .breadcumb-area end -->
<!-- single-product-area start-->
<div class="single-product-area ptb-100">
  <div class="container">
      <div class="row">
          <div class="col-lg-6">
              <div class="product-single-img">
                  <div class="product-active owl-carousel">
                      <div class="item">
                          <img src="{{ asset('uploads/product_photos') }}/{{ $product_info->product_thumbnail_photo }}" alt="No Photo">
                      </div>
                      @foreach ($product_info->productonetomanyproduct_image as $single_photo)
                        <div class="item">
                            <img src="{{ asset('uploads/product_multiple_photos') }}/{{ $single_photo->product_multiple_image }}" alt="No Photo">
                        </div>
                      @endforeach
                  </div>
                  <div class="product-thumbnil-active  owl-carousel">
                      <div class="item">
                        <img src="{{ asset('uploads/product_photos') }}/{{ $product_info->product_thumbnail_photo }}" alt="No Photo">
                      </div>
                      @foreach ($product_info->productonetomanyproduct_image as $single_photo)
                        <div class="item">
                            <img src="{{ asset('uploads/product_multiple_photos') }}/{{ $single_photo->product_multiple_image }}" alt="No Photo">
                        </div>
                        @endforeach
                  </div>
              </div>
          </div>
          <div class="col-lg-6">
              <div class="product-single-content">
                  <h3>{{ $product_info->product_name }}</h3>
                  <div class="rating-wrap fix">
                      <span class="pull-left float-left">${{ $product_info->product_price }}</span>
                      <ul class="rating pull-right float-right">
                         @if (average_star($product_info->id) == 0)
                            <li><i class="far fa-star"></i></li>
                            <li><i class="far fa-star"></i></li>
                            <li><i class="far fa-star"></i></li>
                            <li><i class="far fa-star"></i></li>
                            <li><i class="far fa-star"></i></li>
                         @else
                            @for ($i = 1; $i <= average_star($product_info->id); $i++)
                                <li><i class="fa fa-star"></i></li>
                            @endfor
                         @endif
                          <li>({{ review_customer_count($product_info->id) }} Customar Review)</li>
                      </ul>
                  </div>
                  <p>{{ $product_info->product_short_description }}</p>
                  <ul class="input-style">
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $product_info->id }}" name="product_id">
                        <li class="quantity cart-plus-minus">
                            <input type="text" value="1" name="product_quantity">
                        </li>
                        <li><button type="submit" class="btn btn-danger btn-sm">Add to Cart</button></li>
                    </form>
                  </ul>
                  <ul class="cetagory">
                      <li>Categories:</li>
                      <li><a href="#">{{ $product_info->productonetoonecategory->category_name }}</a></li>
                  </ul>
                  <ul class="socil-icon"> 
                      <li>Share :</li>
                      <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                      <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                      <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                      <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                      <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                  </ul>
              </div>
          </div>
      </div>
      <div class="row mt-60">
          <div class="col-12">
              <div class="single-product-menu">
                  <ul class="nav">
                      <li><a class="active" data-toggle="tab" href="#description">Description</a> </li>
                      <li><a data-toggle="tab" href="#tag">Faq</a></li>
                      <li><a data-toggle="tab" href="#review">Review</a></li>
                  </ul>
              </div>
          </div>
          <div class="col-12">
              <div class="tab-content">
                  <div class="tab-pane active" id="description">
                      <div class="description-wrap">
                         <p>{!! $product_info->product_long_description !!}</p>
                      </div>
                  </div>
                  <div class="tab-pane" id="tag">
                      <div class="faq-wrap" id="accordion">
                          @forelse ($faqs as $faq)
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5><button data-toggle="collapse" data-target="#faq_id{{ $faq->id }}" aria-expanded="true" aria-controls="faq_id{{ $faq->id }}">{{  $faq->faq_question  }}</button> </h5>
                                </div>
                                <div id="faq_id{{ $faq->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        {{  $faq->faq_answer  }}
                                    </div>
                                </div>
                            </div>
                          @empty
                              No Data Found
                          @endforelse
                      </div>
                  </div>
                  <div class="tab-pane" id="review">
                      <div class="review-wrap">
                          <ul>
                              @forelse ($reviews as $review)
                                <li class="review-items">
                                    <div class="review-img">
                                        <img style="width: 100px; height: 100px; border-radius: 50%" src="{{ asset('uploads\profile_photos') }}/{{ App\User::find($review->user_id)->profile_photo }}" alt="">
                                    </div>
                                    <div class="review-content">
                                        <h3><a href="#">{{ App\User::find($review->user_id)->name }}</a></h3>
                                        <span>{{ $review->updated_at->format('d M, Y') }} AT {{ $review->updated_at->format('h:i A') }}</span>
                                        <p>{{ $review->review }}</p>
                                        <ul class="rating">
                                            @for ($i = 1; $i <= $review->stars; $i++)
                                                <li><i class="fa fa-star"></i></li>
                                            @endfor
                                        </ul>
                                    </div>
                                </li>
                              @empty
                                  No review 
                              @endforelse
                           
                          </ul>
                      </div>
                      @auth
                        @if ($show_review_form == 1)
                            <div class="add-review">
                                <h4>Add A Review</h4>
                                <form action="{{ route('review.post') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="order_details_id" value="{{ $order_details_id }}">
                                    <div class="ratting-wrap">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>task</th>
                                                    <th>1 Star</th>
                                                    <th>2 Star</th>
                                                    <th>3 Star</th>
                                                    <th>4 Star</th>
                                                    <th>5 Star</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>How Many Stars?</td>
                                                    <td>
                                                        <input type="radio" name="stars" value="1" />
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="stars" value="2" />
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="stars" value="3" />
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="stars" value="4" />
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="stars" value="5" />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @error('stars')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>Your Review:</h4>
                                            <textarea class="mb-0" name="review" id="review" cols="30" rows="10" placeholder="Your review here..."></textarea>
                                            @error('review')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn-style">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                      @endauth
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<!-- single-product-area end-->
<!-- featured-product-area start -->
<div class="featured-product-area">
  <div class="container">
      <div class="row">
          <div class="col-12">
              <div class="section-title text-left">
                  <h2>Related Product</h2>
              </div>
          </div>
      </div>
      <div class="row">
          @forelse ($related_product as $related_product)
          <div class="col-lg-3 col-sm-6 col-12">
              <div class="featured-product-wrap">
                  <div class="featured-product-img">
                      <img src="{{ asset('uploads/product_photos') }}/{{ $related_product->product_thumbnail_photo }}" alt="No Photo Found">
                  </div>
                  <div class="featured-product-content">
                      <div class="row">
                          <div class="col-7">
                              <h3><a href="{{ url('product/details') }}/{{ $related_product->slug }}">{{ $related_product->product_name }}</a></h3>
                              <p>${{ $related_product->product_price }}</p>
                          </div>
                          <div class="col-5 text-right">
                              <ul>
                                  <li><a href="cart.html"><i class="fa fa-shopping-cart"></i></a></li>
                                  <li><a href="{{ route('wishlist.store', $related_product->id) }}"><i class="fa fa-heart"></i></a></li>
                              </ul>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          @empty
              <div class="alert alert-danger">No Related product to show</div>
          @endforelse
      </div>
  </div>
</div>
<!-- featured-product-area end -->

@endsection