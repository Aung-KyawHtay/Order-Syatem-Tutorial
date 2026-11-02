@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

<div class="container-fluid">

    {{-- Welcome Section --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-2">
            Welcome Back, {{ auth()->user()->name }}!
        </h4>

        <p class="text-muted mb-0">
            Here's what's happening with your order system today.
        </p>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-4">

        {{-- Total Items --}}
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Items</p>
                            <h3 class="fw-bold mb-0">
                                {{ number_format($totalItems) }}
                            </h3>
                        </div>

                        <i class="bi bi-box-seam fs-2 text-success"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Orders --}}
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Orders</p>
                            <h3 class="fw-bold mb-0">
                                {{ number_format($totalOrders) }}
                            </h3>
                        </div>

                        <i class="bi bi-receipt fs-2 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending Orders --}}
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Pending Orders</p>
                            <h3 class="fw-bold mb-0">
                                {{ number_format($pendingOrders) }}
                            </h3>
                        </div>

                        <i class="bi bi-clock-history fs-2 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Completed Orders --}}
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Completed Orders</p>
                            <h3 class="fw-bold mb-0">
                                {{ number_format($completedOrders) }}
                            </h3>
                        </div>

                        <i class="bi bi-check-circle fs-2 text-success"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Recent Orders --}}
    <div class="card border-0 shadow-sm mt-4">

        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">
                    Recent Orders
                </h5>

                <a href="{{ route('orders.index') }}"
                    class="btn btn-sm btn-outline-success">
                    View All
                    <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($recentOrders as $order)

                        @php
                        $statusClass = match (strtolower($order->status)) {
                        'completed' => 'bg-success',
                        'pending' => 'bg-warning text-dark',
                        'processing' => 'bg-primary',
                        'cancelled' => 'bg-danger',
                        default => 'bg-secondary',
                        };
                        @endphp

                        <tr>
                            <td>
                                #ORD-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}
                            </td>

                            <td>
                                {{ $order->user?->name ?? 'Unknown' }}
                            </td>

                            <td>
                                {{ $order->created_at->format('Y-m-d') }}
                            </td>

                            <td>
                                {{ number_format($order->total_amount, 2) }}
                            </td>

                            <td>
                                <span class="badge {{ $statusClass }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ route('orders.show', $order->id) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                    View
                                </a>
                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                No orders found.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection