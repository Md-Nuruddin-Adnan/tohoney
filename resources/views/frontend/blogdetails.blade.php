@extends('layouts.frontend_app')

@section('title')
    Tohoney | Blog Details
@endsection

@section('blog')
    active
@endsection

@section('frontend_content')
<!-- .breadcumb-area start -->
<div class="breadcumb-area bg-img-4 ptb-100">
  <div class="container">
      <div class="row">
          <div class="col-12">
              <div class="breadcumb-wrap text-center">
                  <h2>Blog Details</h2>
                  <ul>
                      <li><a href="{{ route('blogpage') }}">Blog</a></li>
                      <li><span>{{ $blog_info->blog_title }}</span></li>
                  </ul>
              </div>
          </div>
      </div>
  </div>
</div>
<!-- .breadcumb-area end -->
<!-- blog-details-area start-->
<div class="blog-details-area ptb-100">
  <div class="container">
      <div class="row">
          <div class="col-lg-9 col-12">
              <div class="blog-details-wrap">
                  <img src="{{ asset('uploads/blog_details_photos') }}/{{ $blog_info->blog_details_photo }}" alt="">
                  <h3>{{ $blog_info->blog_title }}</h3>
                  <ul class="meta">
                      <li>{{ $blog_info->created_at->format('d M Y') }}</li>
                      <li>{{ $blog_info->user->name }}</li>
                  </ul>
                  <p>{!! $blog_info->blog_description !!}</p>
                  <div class="share-wrap">
                      <div class="row">
                          <div class="col-sm-7 ">
                              <ul class="socil-icon d-flex">
                                  <li>share it on :</li>
                                  <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                  <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                  <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                  <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                                  <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                              </ul>
                          </div>
                          <div class="col-sm-5 text-right">
                              @if (App\Blog::where('id', '>', $blog_info->id)->min('id') == '')
                                
                              @else
                                <a href="{{ url('blog/details') }}/{{ $blog_info->id }}">Next Post <i class="fa fa-long-arrow-right"></i></a>
                              @endif
                          </div>
                      </div>
                  </div>
              </div>
              <div class="comment-form-area">
                  <div class="comment-main">
                      <h3 class="blog-title"><span>({{ $total_comments }})</span>Comments:</h3>
                      <ol class="comments">
                          <li class="comment even thread-even depth-1">
                              @forelse ($comments as $comment)
                              <div class="comment-wrap pb-0">
                                  <div class="comment-theme">
                                      <div class="comment-image">
                                          <img style="width: 100px; border-radius: 50%" src="{{ asset('uploads/profile_photos') }}/{{ $comment->user->profile_photo }}" alt="Jhon">
                                      </div>
                                  </div>
                                  <div class="comment-main-area">
                                      <div class="comment-wrapper">
                                          <div class="sewl-comments-meta">
                                              <h4>{{ $comment->user->name }}</h4>
                                              <span>{{ $comment->created_at->format('d M Y') }} AT {{ $comment->created_at->format('h:i a') }}</span>
                                          </div>
                                          <div class="comment-area">
                                              <p>{{ $comment->message }}</p>
                                          </div>
                                      </div>
                                      <div>
                                        <a class="btn btn-sm btn-light shadow mb-3" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $comment->id }}"
                                        aria-expanded="true" aria-controls="collapse{{ $comment->id }}">
                                          <i class="fas fa-reply"></i> Reply
                                        </a>
                                        <div id="collapse{{ $comment->id }}" class="collapse">
                                            <div id="respond" class="sewl-comment-form comment-respond form-style">
                                                <form method="post" class="comment-form" action="{{ route('reply.post') }}">
                                                  @csrf
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="sewl-form-textarea no-padding-right">
                                                                <textarea id="comment" name="reply_message" tabindex="4" rows="3" cols="30" placeholder="Write Your Comments..."></textarea>
                                                                @error('reply_message')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <input name="comment_id" id="comment_parent" value="{{ $comment->id }}" type="hidden">
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-submit">
                                                                <input class="my-3 m-0" name="submit" id="submit" value="Send" type="submit">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                      </div>
                                        <!-- Reply Start --> 
                                        @forelse (App\Reply::where('comment_id', $comment->id)->get() as $reply)
                                        <div class="comment-wrap border-bottom-0 mb-2 pb-0">
                                            <div class="comment-theme mr-2">
                                                <div class="comment-image">
                                                    <img style="width: 50px; border-radius: 50%" src="{{ asset('uploads/profile_photos') }}/{{ $reply->user->profile_photo }}" alt="Jhon">
                                                </div>
                                            </div>
                                            <div class="comment-main-area">
                                                <div class="comment-wrapper">
                                                    <div class="sewl-comments-meta">
                                                        <h4>{{ $reply->user->name }}</h4>
                                                        <span>{{ $reply->created_at->format('d M Y') }} AT {{ $reply->created_at->format('h:i a') }}</span>
                                                    </div>
                                                    <div class="comment-area">
                                                        <p>{{ $reply->reply_message }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                            
                                        @endforelse
                                        <!-- Reply End --> 
                                  </div>
                                </div>
                              @empty
                                  <div class="py-3">No comments yet</div>
                              @endforelse
                          </li>
                      </ol>
                  </div>
                  <div id="respond" class="sewl-comment-form comment-respond form-style">
                      <h3 id="reply-title" class="blog-title">Leave a <span>comment</span></h3>
                      <form novalidate="" method="post" id="commentform" class="comment-form" action="{{ route('blog.comment') }}">
                        @csrf
                          <div class="row">
                              <div class="col-12">
                                  <div class="sewl-form-textarea no-padding-right">
                                      <textarea id="comment" name="message" tabindex="4" rows="3" cols="30" placeholder="Write Your Comments..."></textarea>
                                      @error('message')
                                          <span class="text-danger">{{ $message }}</span>
                                      @enderror
                                  </div>
                                  <input name="blog_id" id="comment_parent" value="{{ $blog_info->id }}" type="hidden">
                              </div>
                              <div class="col-12">
                                  <div class="form-submit">
                                      <input name="submit" id="submit" value="Send" type="submit">
                                  </div>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
          <div class="col-lg-3 col-12">
              <aside class="sidebar-area">
                  <div class="widget widget_categories">
                      <h4 class="widget-title">Categories</h4>
                      <ul>
                        @foreach ($blog_categories as $blog_category)
                          <li><a href="#">{{ $blog_category->category_name }}</a></li>
                        @endforeach
                      </ul>
                  </div>
                  <div class="widget widget_recent_entries recent_post">
                      <h4 class="widget-title">Related Post</h4>
                      <ul>
                        @forelse ($related_blogs as $related_blog)
                          <li>
                              <div class="post-img">
                                  <img src="{{ asset('uploads/blog_thumbnail_photos') }}/{{ $related_blog->blog_thumbnail_photo }}" alt="" style="width: 70px">
                              </div>
                              <div class="post-content">
                                  <a href="{{ url('blog/details') }}/{{ $related_blog->slug}}">{{ $related_blog->blog_title}} </a>
                                  <p>{{ $blog_info->created_at->format('d M Y') }}</p>
                              </div>
                          </li>  
                        @empty
                            <p>No related post</p>
                        @endforelse
                      </ul>
                  </div>
              </aside>
          </div>
      </div>
  </div>
</div>
<!-- blog-details-area end -->
@endsection