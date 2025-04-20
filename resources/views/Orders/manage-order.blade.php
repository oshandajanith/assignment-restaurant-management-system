
@extends('layouts.layouts.dashboard_layout')
@section('body-area')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<title>ManageOrder</title>
<div class="content container-fluid">
				
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Manage Order</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item active">Manage Order</li>
                            </ul>
                        </div>
                       
                    </div>
                </div>
                <!-- /Page Header -->
                
                
                <div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table id="ordersTable" class="table table-striped custom-table mb-0">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User</th>
                        <th>Concessions</th>
                        <th>Send To Kitchen Time</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td><strong>OI/{{ $order->id }}</strong></td>
                        <td>{{ $order->user->name }}</td>
                        <td>
                            @foreach($order->concessions as $concession)
                                <span class="badge badge-info">
                                    {{ $concession->name }} (Rs. {{ number_format($concession->price, 2) }})
                                </span><br>
                            @endforeach
                        </td>
                        <td>{{ \Carbon\Carbon::parse($order->send_to_kitchen_time)->format('Y-m-d H:i') }}</td>
                        <td>
                                <span class="badge 
                                    @if($order->status == 'Pending') badge-warning
                                    @elseif($order->status == 'In Kitchen') badge-primary
                                    @elseif($order->status == 'Completed') badge-success
                                    @else badge-secondary @endif">
                                    {{ $order->status }}
                                </span>
                                
                                @if($order->send_to_kitchen_time)
                                <small class="d-block text-muted">
                                    Sent: {{\Carbon\Carbon::parse($order->send_to_kitchen_time)->format('Y-m-d H:i') }}
                                </small>
                                @endif
                            </td>
                        <td class="text-right">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#view_order_{{ $order->id }}">
    <i class="fa fa-eye m-r-5"></i> View
</a>
<form action="{{ route('orders.send-to-kitchen', $order->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="dropdown-item" 
                        onclick="return confirm('Send this order to kitchen now?')">
                    <i class="fa fa-paper-plane m-r-5"></i> Send to Kitchen
                </button>
            </form>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_order_{{ $order->id }}">
                                                        <i class="fa fa-trash-o m-r-5"></i> Delete
                                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
            </div>
            <!-- /Page Content -->
            
           
            
         
<!-- View Order Modal -->
@foreach($orders as $order)        
<div id="view_order_{{ $order->id }}" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details #{{ $order->id }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Order ID</label>
                                <input class="form-control" value="{{ $order->id }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Order Created by</label>
                                <input class="form-control" value="{{ $order->user->name }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Order Time</label>
                                <input class="form-control" value="{{ \Carbon\Carbon::parse($order->send_to_kitchen_time)->format('Y-m-d H:i') }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kitchen Time</label>
                                <input class="form-control" value="{{ \Carbon\Carbon::parse($order->send_to_kitchen_time)->format('Y-m-d H:i') }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <input class="form-control" value="{{ $order->status }}" readonly>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Concessions</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Image</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->concessions as $concession)
                                        <tr>
                                            <td>{{ $concession->name }}</td>
                                            <td><img src="{{ asset($concession->image) }}" width="60"></td>
                                            <td>Rs. {{ number_format($concession->price, 2) }}</td>
                                            <td>{{ $concession->pivot->quantity }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="submit-section text-center mt-4">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
           <!-- Delete Concession Modal -->
@foreach($orders as $order)
<div class="modal custom-modal fade" id="delete_order_{{ $order->id }}" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Order</h3>
                    <p>Are you sure you want to delete this Order?</p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <div class="col-6">
                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-primary continue-btn w-100">Delete</button>
                            </form>
                        </div>
                        <div class="col-6">
                            <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

 
<script>
    $(function () {
        $('#ordersTable').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
            responsive: true,
            ordering: true,
            columnDefs: [
                { orderable: false, targets: [2, 5] }
            ],
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