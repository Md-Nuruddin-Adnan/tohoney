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
      <span class="breadcrumb-item active">Faq</span>
  </nav>

  <div class="sl-pagebody">
      <div class="sl-page-title">
      <h5>Faq</h5>
      <p>This is a Faq page</p>
      </div><!-- sl-page-title -->
      <!-- ########## START CODE HERE ########## -->

      <div class="row">
        <div class="col-lg-8">
          <div class="card">
            <div class="card-header card-header-default">
              Faq
            </div>
            <div class="card-body">
              @if (session('faq_delete_status'))
                <div class="alert alert-danger">{{ session('faq_delete_status') }}</div>
              @endif
              @if (session('mark_delete_status'))
                <div class="alert alert-danger">{{ session('mark_delete_status') }}</div>
              @endif
              <form action="{{ route('markdeletefaq') }}" method="POST" id="mark_delete_form">
                @csrf
                <div class="table-responsive">
                  <table class="table" id="faq_table">
                    <thead>
                      <tr>
                        <th>
                          <label class="ckbox mg-b-0">
                            <input type="checkbox" id="select-all"><span></span>
                          </label>
                        </th>
                        <th>Sl. No</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Created</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($faqs as $faq)
                      <tr>
                        <td>
                          <label class="ckbox mg-b-0">
                            <input type="checkbox" name="faq_id[]" value="{{ $faq->id }}" class="faq_id_checkbox"><span></span>
                          </label>
                        </td>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $faq->faq_question }}</td>
                        <td>{{ $faq->faq_answer }}</td>
                        <td class="text-nowrap">
                          <li>{{ App\user::findOrFail($faq->created_by)->name }}</li>
                          <li>{{ $faq->created_at->diffForHumans() }}</li>
                        </td>
                        <td>
                          <div class="btn-group">
                            <a href="{{ route('faq.edit', $faq->id) }}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Edit"><i class="fas fa-edit"></i></a>
                            <button type="button" class="btn btn-danger btn_delete" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Delete" value="{{ route('faqdelete', $faq->id) }}"><i class="fas fa-trash-alt"></i></button>
                          </div>
                        </td>
                      </tr>
                      @empty
                      <tr>
                        <td colspan="50" class="text-center text-danger">No Data Foud</td>
                      </tr>
                      @endforelse
                    
                    </tbody>
                  </table>
                </div>
              </form>
              @if ($faqs->count() > 0)
                <button type="button" class="btn btn-danger" id="mark_delete_btn">Mark Delete</button>
              @endif
            </div>
          </div>
        </div>


        <div class="col-lg-4">
          <div class="card">
            <div class="card-header card-header-default">Add faq</div>
            <div class="card-body">
              @if (session('faq_success_status'))
                <div class="alert alert-success">{{ session('faq_success_status') }}</div>
              @endif
              <form action="{{ route('faq.store') }}" method="POST">
                @csrf
                <div class="form-group">
                  <label>faq Question</label>
                  <input type="text" name="faq_question" class="form-control" placeholder="Enter faq question" value="{{ old('faq_question') }}">
                  @error('faq_question')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="form-group">
                  <label>faq answer</label>
                  <textarea name="faq_answer" class="form-control" placeholder="Enter faq answer" rows="4">{{ old('faq_answer') }}</textarea>
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

@section('footer_script')
<script>
  $(function(){
    'use strict';

    // Sweetalert delete start
    $('#faq_table').on('click', '.btn_delete', function(){
      Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
        var delete_link = $(this).val();
        window.location.href = delete_link;
        }
      })
    })
    //Sweetalert delete end

    // Sweetalert Mark Delete start
    $("#mark_delete_btn").click(function(){
      Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
          $("#mark_delete_form").submit();
        }
      })
    })
    //Sweetalert Mark Delete end

    // Checkbox all checked
    document.getElementById('select-all').onclick = function() {
      var checkboxes = document.querySelectorAll('#faq_table input[type="checkbox"]');
      for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
      }
    }



  });
</script>
@endsection