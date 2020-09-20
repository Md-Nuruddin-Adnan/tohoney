@extends('layouts.frontend_app')

@section('title')
  Tohoney | Shop
@endsection

@section('frontend_content')
 <!-- .breadcumb-area start -->
 <div class="breadcumb-area bg-img-4 ptb-100">
   <div class="container">
     <div class="row">
       <div class="col-12">
         <div class="breadcumb-wrap text-center">
           <h2>Frequently Asked Questions (FAQ)</h2>
           <ul>
             <li><a href="{{  url('/') }}">Home</a></li>
             <li><span>Faq</span></li>
           </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- .breadcumb-area end -->

<!-- faq-area start -->
<div class="about-area ptb-100 mb-5">
  <div class="container">
      <div class="row">
          <div class="col-12">
            <div class="about-wrap text-center">
              <h3>FAQ</h3>
            </div>
            <div class="accordion" id="accordionExample">
            @forelse ($faqs as $faq)
            <div class="card border-0">
              <div class="card-header border-0 p-0 my-3">
                  <button class="btn btn-link text-left py-3 collapsed w-100 text-white" type="button" data-toggle="collapse" data-target="#faq_id{{ $faq->id }}" aria-expanded="false" aria-controls="faq_id{{ $faq->id }}">
                    {{  $faq->faq_question  }}
                  </button>
              </div>
              <div id="faq_id{{ $faq->id }}" class="collapse" aria-labelledby="faq_id{{ $faq->id }}" data-parent="#accordionExample">
                <div class="card-body">
                  {{  $faq->faq_answer  }}
                </div>
              </div>
            </div>
            @empty
                
            @endforelse
            </div>
          </div>
      </div>
  </div>
</div>
<!-- faq-area end -->
@endsection