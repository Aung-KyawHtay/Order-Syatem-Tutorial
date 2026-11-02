@extends('layouts.app')

@section('title', 'Create Item')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Create New Item</h4>
        <p class="text-muted mb-0">Add a new item to your inventory.</p>
    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h6 class="fw-bold mb-0">Item Information</h6>
        </div>

        <div class="card-body">

            <form action="{{ route('items.store') }}" method="POST">

                @csrf

                {{-- Item Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">
                        Item Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        placeholder="Enter item name">

                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- SKU --}}
                <div class="mb-3">
                    <label for="sku" class="form-label fw-semibold">
                        SKU
                    </label>

                    <input
                        type="text"
                        name="sku"
                        id="sku"
                        class="form-control @error('sku') is-invalid @enderror"
                        value="{{ old('sku') }}"
                        placeholder="Example: KEY-001">

                    @error('sku')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">
                        Description
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        rows="3"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Enter item description">{{ old('description') }}</textarea>

                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">

                    {{-- Price --}}
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label fw-semibold">
                            Price
                        </label>

                        <input
                            type="number"
                            name="price"
                            id="price"
                            step="0.01"
                            min="0"
                            class="form-control @error('price') is-invalid @enderror"
                            value="{{ old('price') }}"
                            placeholder="Enter price">

                        @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Quantity --}}
                    <div class="col-md-6 mb-3">
                        <label for="quantity" class="form-label fw-semibold">
                            Quantity
                        </label>

                        <input
                            type="number"
                            name="quantity"
                            id="quantity"
                            min="0"
                            class="form-control @error('quantity') is-invalid @enderror"
                            value="{{ old('quantity', 0) }}"
                            placeholder="Enter quantity">

                        @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- Buttons --}}
                <div class="d-flex gap-2 mt-3">

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-lg me-1"></i>
                        Save Item
                    </button>

                    <a href="{{ route('items.index') }}" class="btn btn-light border">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection