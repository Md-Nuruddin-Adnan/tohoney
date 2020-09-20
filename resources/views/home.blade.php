@extends('layouts.dashboard_app')

@section('title')
    Home
@endsection

@section('home')
  active
@endsection

@section('dashboard_content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <span class="breadcrumb-item active">Home</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Dashboard</h5>
            <p>This is a Dynamic Dashboard</p>
        </div><!-- sl-page-title -->
    <!-- ########## START CODE HERE ########## -->

    <!-- send newsletter to all users -->
    <div class="card mb-3">
        <div class="card-header">
            @if (session('newsletter_success_status'))
                <div class="alert alert-success mb-3" role="alert">
                    {{ session('newsletter_success_status') }}
                </div>
            @endif
            <a href="{{ url('send/newsletter') }}" class="btn btn-success">Send Newsletter to {{ $total_users }} users</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4>Total users: {{ $total_users }}</h4>
                        <h4>Total Sum: {{ $total_sum }}</h4>
                        <h4>Total Avg: {{ $avg_users }}</h4>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-dark">
                            <thead>
                                <tr>
                                    <th>SL. No</th>
                                    <th>ID. No</th>
                                    <th>Name</th>
                                    <th>Email Address</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        {{-- <td>{{ $loop->index + 1 }}</td>  --}} {{-- if there is no paginate than use this --}}
                                        <td>{{ $users->firstItem() + $loop->index }}</td>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ Str::title($user->name) }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            {{-- use this formate to see specific time zone --}}
                                            {{-- <li>Date: {{ $user->created_at->timezone('America/Los_Angeles')->format('d/m/Y') }}</li>
                                            <li>Time: {{ $user->created_at->timezone('America/Los_Angeles')->format('h:i:s A') }}</li> --}}
                                            <li>Date: {{ $user->created_at->format('d/m/Y') }}</li>
                                            <li>Time: {{ $user->created_at->format('h:i:s A') }}</li>
                                            <li>{{ $user->created_at->diffForHumans() }}</li>
                                        </td>
                                        <td>
                                            @isset($user->updated_at)
                                                <li>Date: {{ $user->updated_at->format('d/m/Y') }}</li>
                                                <li>Time: {{ $user->updated_at->format('h:i:s A') }}</li>
                                                <li>Time: {{ $user->updated_at->diffForHumans() }}</li>
                                            @endisset
                                        </td>
                                    </tr>
                                @empty
                                    
                                @endforelse
                            </tbody>
                        </table>
                        {{ $users->links() }}
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- ########## END CODE HERE ########## -->
    </div><!-- sl-pagebody -->
</div><!-- sl-mainpanel -->
<!-- ########## END: MAIN PANEL ########## -->
@endsection