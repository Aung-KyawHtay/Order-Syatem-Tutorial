@extends('layouts.app')

@section('title', 'Items')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">Items</h4>
            <p class="text-muted mb-0">Manage your inventory items.</p>
        </div>

        <a href="{{ route('items.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i>
            Add New Item
        </a>

    </div>

    {{-- Success Message --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show"
        role="alert"
        id="success-alert">

        {{ session('success') }}

        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>
    </div>
    @endif

    {{-- Error Message --}}
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}

        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>
    </div>
    @endif

    {{-- Items Table --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h6 class="fw-bold mb-0">Item List</h6>
        </div>

        <div class="card-body">

            {{-- Search Form --}}
            <form action="{{ route('items.index') }}" method="GET" class="mb-3">

                <div class="row g-2">

                    <div class="col-md-5">
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search by name, SKU or description..."
                            value="{{ request('search') }}">
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-search me-1"></i>
                            Search
                        </button>
                    </div>

                    <div class="col-auto">
                        <a href="{{ route('items.index') }}" class="btn btn-outline-secondary">
                            Clear
                        </a>
                    </div>

                </div>

            </form>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Item Name</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($items as $item)

                        <tr>
                            <td>{{ $item->id }}</td>

                            <td class="fw-semibold">
                                {{ $item->name }}
                            </td>

                            <td>
                                {{ $item->sku }}
                            </td>

                            <td>
                                {{ number_format($item->price, 2) }}
                            </td>

                            <td>
                                {{ $item->quantity }}
                            </td>

                            <td>
                                <a href="{{ route('items.edit', $item->id) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('items.destroy', $item->id) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to delete this item?')">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>
                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No items found.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-end mt-3">

                {{ $items->links() }}

            </div>

        </div>

    </div>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const successAlert = document.getElementById('success-alert');

        if (successAlert) {

            setTimeout(function() {

                successAlert.style.transition = 'opacity 0.5s ease';
                successAlert.style.opacity = '0';

                setTimeout(function() {
                    successAlert.remove();
                }, 500);

            }, 3000);

        }

    });
</script>

@endsection