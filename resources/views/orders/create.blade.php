@extends('layouts.app')

@section('title', 'Create Order')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Create Order</h4>
            <p class="text-muted mb-0">Select items and enter quantities.</p>
        </div>

        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back to Orders
        </a>
    </div>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <div class="card border-0 shadow-sm">
            {{-- Success Message --}}
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            {{-- Error Message --}}
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">Available Items</h6>
            </div>

            <div class="card-body">

                @if ($items->isEmpty())
                <div class="text-center text-muted py-4">
                    No items available in stock.
                </div>
                @else

                @foreach ($items as $index => $item)

                <div class="row align-items-center border-bottom py-3">

                    <div class="col-md-4">
                        <strong>{{ $item->name }}</strong>
                        <div class="text-muted small">
                            SKU: {{ $item->sku }}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <span>
                            Price:
                            {{ number_format($item->price, 2) }}
                        </span>
                    </div>

                    <div class="col-md-3">
                        @if ($item->quantity > 0)
                        <span class="badge bg-success">
                            In Stock: {{ $item->quantity }}
                        </span>
                        @else
                        <span class="badge bg-danger">
                            Out of Stock
                        </span>
                        @endif
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
                            max="{{ $item->quantity }}"
                            value="0"
                            {{ $item->quantity <= 0 ? 'disabled' : '' }}>

                        <input
                            type="hidden"
                            name="items[{{ $index }}][item_id]"
                            value="{{ $item->id }}">
                    </div>

                </div>

                @endforeach

                @endif

                @error('items')
                <div class="text-danger small mt-3">
                    {{ $message }}
                </div>
                @enderror

                @error('items.*.quantity')
                <div class="text-danger small mt-2">
                    {{ $message }}
                </div>
                @enderror

                @error('items.*.item_id')
                <div class="text-danger small mt-2">
                    {{ $message }}
                </div>
                @enderror

            </div>

            <div class="card-footer bg-white text-end py-3">

                <button
                    type="submit"
                    class="btn btn-success"
                    @disabled($items->isEmpty())>

                    <i class="bi bi-plus-circle me-1"></i>
                    Create Order

                </button>

            </div>

        </div>

    </form>

</div>

@endsection