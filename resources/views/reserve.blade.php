@extends('layouts.dashboard_app')

@section('title')
    your title
@endsection

@section('page name')
  active
@endsection

@section('dashboard_content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
        <span class="breadcrumb-item active">your link</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
        <h5>your link</h5>
        <p>This is a your link page</p>
        </div><!-- sl-page-title -->
        <!-- ########## START CODE HERE ########## -->

        

        <!-- ########## END CODE HERE ########## -->
    </div><!-- sl-pagebody -->
</div><!-- sl-mainpanel -->
<!-- ########## END: MAIN PANEL ########## -->
@endsection