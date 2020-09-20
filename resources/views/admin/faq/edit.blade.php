@extends('layouts.dashboard_app')

@section('title')
    faq
@endsection

@section('faq')
  active
@endsection

@section('dashboard_content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
  <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
      <a class="breadcrumb-item" href="{{ route('faq.index') }}">Faq</a>
      <span class="breadcrumb-item active">{{ $faq_info->faq_question }}</span>
  </nav>

  <div class="sl-pagebody">
      <div class="sl-page-title">
      <h5>Faq</h5>
      <p>This is a Faq edit page</p>
      </div><!-- sl-page-title -->
      <!-- ########## START CODE HERE ########## -->

      <div class="row">
        <div class="col-lg-6 m-auto">
          <div class="card">
            <div class="card-header card-header-default">Add faq</div>
            <div class="card-body">
              @if (session('faq_success_status'))
                <div class="alert alert-success">{{ session('faq_success_status') }}</div>
              @endif
              <form action="{{ route('faq.update', $faq_info->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                  <label>faq Question</label>
                  <input type="text" name="faq_question" class="form-control" placeholder="Enter faq question" value="{{ $faq_info->faq_question }}">
                  @error('faq_question')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="form-group">
                  <label>faq answer</label>
                  <textarea name="faq_answer" class="form-control" placeholder="Enter faq answer" rows="6">{{ $faq_info->faq_answer }}</textarea>
                  @error('faq_answer')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-info">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      

      <!-- ########## END CODE HERE ########## -->
  </div><!-- sl-pagebody -->
</div><!-- sl-mainpanel -->
<!-- ########## END: MAIN PANEL ########## -->

@endsection

