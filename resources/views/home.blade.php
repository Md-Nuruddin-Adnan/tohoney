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
            @if (Auth::user()->role == 1)
                <h4>You are Admin</h4>
            @endif
        </div><!-- sl-page-title -->
    <!-- ########## START CODE HERE ########## -->
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <canvas id="dashboard_chart_1"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <canvas id="dashboard_chart_2"></canvas>
                </div>
            </div>
        </div>
    </div>

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
                <div class="card-header card-header-default">
                    Total users: {{ $total_users }}
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

@section('footer_script')
<script>
    var ctx = document.getElementById('dashboard_chart_1').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Paid', 'Unpaid', 'Refund'],
            datasets: [{
                label: '# of Votes',
                data: [{{ $paid }}, {{ $unpaid }}, {{ $refund }}],
                backgroundColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                ],
                // borderColor: [
                //     'rgba(255, 99, 132, 1)',
                //     'rgba(75, 192, 192, 1)',
                //     'rgba(255, 159, 64, 1)',
                // ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var ctx = document.getElementById('dashboard_chart_2').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Stock', 'Sell'],
            datasets: [{
                data: [{{ $total_stock_price }}, {{ $total_sell }}],
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(75, 192, 192, 1)',
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            legend: {
                display: false
            },
        }
    });
</script>
@endsection