@extends('layouts.dashboard_app')

@section('title')
    Contact View
@endsection

@section('contactview')
  active
@endsection

@section('dashboard_content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
        <span class="breadcrumb-item active">Contact</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
        <h5>Contact Message</h5>
        <p>This is contact page</p>
        </div><!-- sl-page-title -->
        <!-- ########## START CODE HERE ########## -->

        <div class="card">
          <div class="card-header card-header-default">
            Total Message: {{ $contacts->count() }}
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table" id="contact_table">
                <thead>
                  <tr>
                    <th>Sl. No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Created at</th>
                    <th>File</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($contacts as $contact)
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $contact->contact_name }}</td>
                    <td>{{ $contact->contact_email }}</td>
                    <td>{{ $contact->contact_subject }}</td>
                    <td>{{ $contact->contact_message }}</td>
                    <td>{{ $contact->created_at->diffForHumans() }}</td>
                    <td>
                      {{-- <i class="fas fa-file"></i> --}}
                      @if($contact->contact_attachment)
                      <a href="{{ url('contact/upload/download') }}/{{ $contact->id }}"> <i class="fas fa-download"></i></a>
                      <a target="_blank" href="{{ asset('storage') }}/{{ $contact->contact_attachment }}"> <i class="fas fa-file"></i></a>
                      @endif
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="50" class="text-danger text-center"><h4>No Data Availble</h4></td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>

        

        <!-- ########## END CODE HERE ########## -->
    </div><!-- sl-pagebody -->
</div><!-- sl-mainpanel -->
<!-- ########## END: MAIN PANEL ########## -->
@endsection

@section('footer_script')
<script>
  $(function(){
    'use strict';

    $('#contact_table').DataTable({
      responsive: false,
      language: {
        searchPlaceholder: 'Search...',
        sSearch: '',
        lengthMenu: '_MENU_ items/page',
      }
    });

  });
</script>
@endsection