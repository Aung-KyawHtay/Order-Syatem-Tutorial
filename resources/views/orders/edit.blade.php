@extends('layouts.app')

@section('title', 'Edit Order')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit Order #{{ $order->id }}</h4>
            <p class="text-muted mb-0">Update order items and quantities.</p>
        </div>

        <a href="{{ route('orders.show', $order->id) }}"
            class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back to Details
        </a>
    </div>

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">Available Items</h6>
            </div>

            <div class="card-body">

                @foreach ($items as $index => $item)

                @php
                $oldOrderItem = $order->items->firstWhere('id', $item->id);
                $currentQuantity = $oldOrderItem?->pivot->quantity ?? 0;
                $availableStock = $item->quantity + $currentQuantity;
                @endphp

                <div class="row align-items-center border-bottom py-3">

                    <div class="col-md-4">
                        <strong>{{ $item->name }}</strong>
                        <div class="text-muted small">
                            SKU: {{ $item->sku }}
                        </div>
                    </div>

                    <div class="col-md-3">
                        Price: {{ number_format($item->price, 2) }}
                    </div>

                    <div class="col-md-2">
                        Stock: {{ $availableStock }}
                    </div>

                    <div class="col-md-3">

                        <label class="form-label small">
                            Quantity
                        </label>

                        <input
                            type="number"
                            name="items[{{ $index }}][quantity]"
                            class="form-control"
                            min="0"
                            max="{{ $availableStock }}"
                            value="{{ old("items.$index.quantity", $currentQuantity) }}">

                        <input
                            type="hidden"
                            name="items[{{ $index }}][item_id]"
                            value="{{ $item->id }}">

                    </div>

                </div>

                @endforeach

                @error('items')
                <div class="text-danger small mt-3">{{ $message }}</div>
                @enderror

                @error('items.*.quantity')
                <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror

            </div>

            <div class="card-footer bg-white text-end py-3">

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save me-1"></i>
                    Update Order
                </button>

            </div>

        </div>

    </form>

</div>

@endsection