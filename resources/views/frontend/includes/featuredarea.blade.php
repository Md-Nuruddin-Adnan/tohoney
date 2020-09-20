<!-- featured-area start -->
<div class="featured-area featured-area2">
  <div class="container">
      <div class="row">
          <div class="col-12">
              <div class="featured-active2 owl-carousel next-prev-style">
                @forelse ($active_categories as $active_category)
                  <div class="featured-wrap">
                    <div class="featured-img">
                        <img src="{{ asset('uploads/category_photos') }}/{{ $active_category->category_photo }}" alt="Active category photo">
                        <div class="featured-content">
                            <a href="shop.html">{{ $active_category->category_name}}</a>
                        </div>
                    </div>
                  </div>
                @empty
                    No Data found
                @endforelse
              </div>
          </div>
      </div>
  </div>
</div>
<!-- featured-area end -->