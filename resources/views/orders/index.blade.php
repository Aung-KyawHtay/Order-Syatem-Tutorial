@extends('layouts.app')

@section('title', 'Orders')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">Orders</h4>
            <p class="text-muted mb-0">Manage and track your orders.</p>
        </div>

        <a href="{{ route('orders.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i>
            Create Order
        </a>

    </div>

    {{-- Success Message --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">

        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>
    @endif

    {{-- Error Message --}}
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">

        {{ session('error') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>
    @endif

    {{-- Search Form --}}
    <div class="card border-0 shadow-sm mb-3">

        <div class="card-body">

            <form action="{{ route('orders.index') }}" method="GET">

                <div class="row g-2">

                    <div class="col-md-5">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search by Order ID, status, item name or SKU..."
                            value="{{ request('search') }}">

                    </div>

                    <div class="col-auto">

                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-search me-1"></i>
                            Search
                        </button>

                    </div>

                    <div class="col-auto">

                        <a href="{{ route('orders.index') }}"
                            class="btn btn-outline-secondary">
                            Clear
                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- Orders Table --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">

            <h6 class="fw-bold mb-0">Order List</h6>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>
                            <th>Order ID</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th class="text-center">Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($orders as $order)

                        <tr>

                            {{-- Order ID --}}
                            <td class="fw-semibold">
                                #{{ $order->id }}
                            </td>

                            {{-- Total Amount --}}
                            <td>
                                {{ number_format($order->total_amount, 2) }}
                            </td>

                            {{-- Status --}}
                            <td>

                                @if ($order->status === 'completed')

                                <span class="badge bg-success">
                                    {{ ucfirst($order->status) }}
                                </span>

                                @elseif ($order->status === 'cancelled')

                                <span class="badge bg-danger">
                                    {{ ucfirst($order->status) }}
                                </span>

                                @elseif ($order->status === 'processing')

                                <span class="badge bg-info text-dark">
                                    {{ ucfirst($order->status) }}
                                </span>

                                @else

                                <span class="badge bg-warning text-dark">
                                    {{ ucfirst($order->status) }}
                                </span>

                                @endif

                            </td>

                            {{-- Order Date --}}
                            <td>
                                {{ $order->created_at->format('d M Y') }}
                            </td>

                            {{-- Actions --}}
                            <td>

                                <div class="d-flex justify-content-center gap-2">

                                    {{-- View Order --}}
                                    <a
                                        href="{{ route('orders.show', $order->id) }}"
                                        class="btn btn-sm btn-outline-success"
                                        title="View Order">

                                        <i class="bi bi-eye"></i>
                                        View

                                    </a>

                                    {{-- Edit Order --}}
                                    <a
                                        href="{{ route('orders.edit', $order->id) }}"
                                        class="btn btn-sm btn-outline-warning"
                                        title="Edit Order">

                                        <i class="bi bi-pencil-square"></i>
                                        Edit

                                    </a>

                                    {{-- Delete Order --}}
                                    <form
                                        action="{{ route('orders.destroy', $order->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete Order #{{ $order->id }}? Stock will be restored.')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Delete Order">

                                            <i class="bi bi-trash"></i>
                                            Delete

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="text-center text-muted py-4">

                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>

                                No orders found.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-end mt-3">

                {{ $orders->links() }}

            </div>

        </div>

    </div>

</div>

@endsection