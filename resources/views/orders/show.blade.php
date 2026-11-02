@extends('layouts.app')

@section('title', 'Order Details')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">Order Details</h4>
            <p class="text-muted mb-0">
                View your order information and purchased items.
            </p>
        </div>

        <a href="{{ route('orders.index') }}"
            class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back to Orders
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

    {{-- Order Information --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white py-3">
            <h6 class="fw-bold mb-0">Order Information</h6>
        </div>

        <div class="card-body">

            <div class="row g-3">

                {{-- Order ID --}}
                <div class="col-md-3">

                    <small class="text-muted">Order ID</small>

                    <h6 class="fw-bold">
                        #{{ $order->id }}
                    </h6>

                </div>

                {{-- Order Date --}}
                <div class="col-md-3">

                    <small class="text-muted">Order Date</small>

                    <h6 class="fw-bold">
                        {{ $order->created_at->format('d M Y, h:i A') }}
                    </h6>

                </div>

                {{-- Status --}}
                <div class="col-md-3">

                    <small class="text-muted">Status</small>

                    <div>

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

                    </div>

                </div>

                {{-- Total Amount --}}
                <div class="col-md-3">

                    <small class="text-muted">Total Amount</small>

                    <h5 class="fw-bold text-success">
                        {{ number_format($order->total_amount, 2) }}
                    </h5>

                </div>

            </div>

            {{-- Action Buttons --}}
            <div class="d-flex flex-wrap gap-2 mt-4">

                {{-- Edit Order --}}
                <a href="{{ route('orders.edit', $order->id) }}"
                    class="btn btn-warning">

                    <i class="bi bi-pencil-square me-1"></i>
                    Edit Order

                </a>

                {{-- Delete Order --}}
                <form
                    action="{{ route('orders.destroy', $order->id) }}"
                    method="POST"
                    onsubmit="return confirm('Are you sure you want to delete Order #{{ $order->id }}? The item stock will be restored.')">

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">

                        <i class="bi bi-trash me-1"></i>
                        Delete Order

                    </button>

                </form>

            </div>

        </div>

    </div>

    {{-- Ordered Items --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">

            <h6 class="fw-bold mb-0">Ordered Items</h6>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th>#</th>
                            <th>Item Name</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th class="text-end">Subtotal</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($order->items as $index => $item)

                        <tr>

                            {{-- Number --}}
                            <td>
                                {{ $index + 1 }}
                            </td>

                            {{-- Item Name --}}
                            <td class="fw-semibold">
                                {{ $item->name }}
                            </td>

                            {{-- SKU --}}
                            <td>
                                {{ $item->sku }}
                            </td>

                            {{-- Price Snapshot --}}
                            <td>
                                {{ number_format($item->pivot->price, 2) }}
                            </td>

                            {{-- Quantity --}}
                            <td>
                                {{ $item->pivot->quantity }}
                            </td>

                            {{-- Subtotal --}}
                            <td class="text-end fw-semibold">

                                {{ number_format(
                                        $item->pivot->price * $item->pivot->quantity,
                                        2
                                    ) }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="6"
                                class="text-center text-muted py-4">

                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>

                                No items found for this order.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                    {{-- Grand Total --}}
                    <tfoot class="table-light">

                        <tr>

                            <td colspan="5" class="text-end fw-bold">
                                Grand Total
                            </td>

                            <td class="text-end fw-bold text-success">

                                {{ number_format($order->total_amount, 2) }}

                            </td>

                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection