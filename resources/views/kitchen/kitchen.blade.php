@extends('layouts.layouts.dashboard_layout')

@section('body-area')

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<title>Kitchen Management</title>

<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title"><i class="la la-shopping-cart me-2"></i>Kitchen Management</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Kitchen Management</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="ordersTable" class="table table-striped custom-table mb-0">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>User</th>
                            <th>Concessions</th>
                            <th>Total Cost (Rs)</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>OI/{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'Guest' }}</td>
                            <td>
                                <ul>
                                    @foreach($order->concessions as $concession)
                                        <li>{{ $concession->name }} (Qty: {{ $concession->pivot->quantity }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $order->total_cost }}</td>
                            <td>
                                <span class="badge 
                                    @if($order->status == 'Completed') bg-success 
                                    @elseif($order->status == 'In-Progress') bg-warning 
                                    @else bg-secondary 
                                    @endif">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="text-end">
                                @if($order->status != 'Completed')
                                    <form action="{{ route('orders.update-status', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="Completed">
                                        <button type="submit" class="btn btn-sm btn-success">Mark as Completed</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function () {
        $('#ordersTable').DataTable({
            "order": [[3, "desc"]] ,
            language: {
                paginate: {
                    next: 'Next →',
                    previous: '← Prev'
                },
                lengthMenu: 'Show _MENU_ entries per page',
                search: 'Search:',
            }
        });
        
    });
</script>

@endsection