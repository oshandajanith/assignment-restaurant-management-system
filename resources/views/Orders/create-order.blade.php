@extends('layouts.layouts.dashboard_layout')

@section('body-area')
<title>Create Order</title>
<div class="content container-fluid">

<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Create Order</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Orders</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card p-4 shadow rounded-2xl">
    <h4 class="mb-4"><i class="la la-utensils me-2"></i>Create New Order</h4>

    <form action="{{ route('order.store') }}" method="POST">
        @csrf

        <!-- Select Concessions -->
        <div class="form-group mb-4">
            <label for="concessions" class="mb-2">Select Concessions <span class="text-danger">*</span></label>
            <div class="row">
                @forelse($concessions as $concession)
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm border {{ $errors->has('concessions') ? 'border-danger' : '' }}">
                        <label class="form-check-label p-3 d-block">
                            <input type="checkbox" name="concessions[]" value="{{ $concession->id }}" class="form-check-input me-2">
                            <div class="d-flex align-items-center">
                                <img src="{{ $concession->image }}" alt="{{ $concession->name }}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                <div>
                                    <strong>{{ $concession->name }}</strong><br>
                                    <span class="text-muted">Price: Rs {{ number_format($concession->price, 2) }}</span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
                @empty
                    <p class="text-danger">No concessions available. Please add concessions first.</p>
                @endforelse
            </div>
            @error('concessions')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        <!-- Send to Kitchen Time -->
        <div class="form-group mb-3">
            <label for="send_time">Send to Kitchen Time <span class="text-danger">*</span></label>
            <input type="datetime-local" name="send_time" id="send_time" class="form-control" value="{{ old('send_time') }}" required>
            @error('send_time')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        <!-- Hidden Status -->
        <input type="hidden" name="status" value="Pending">

        <!-- Submit -->
        <button type="submit" class="btn btn-success">
            <i class="la la-plus-circle me-1"></i> Create Order
        </button>
    </form>
</div>
</div>
@endsection
