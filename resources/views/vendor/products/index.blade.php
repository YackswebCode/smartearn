@extends('layouts.vendor')

@section('title', 'My Products')

@section('content')
<div class="container-fluid py-4">
    <!-- Header with title and add button -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <h2 class="fw-bold mb-0">My Products</h2>
        <a href="{{ route('vendor.products.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Add New Product
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Product Grid -->
    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <div class="card h-100 border-0 shadow-sm product-card">
                <!-- Product Image -->
                <div class="product-image-wrapper" style="height: 180px; overflow: hidden; border-top-left-radius: inherit; border-top-right-radius: inherit;">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             class="card-img-top w-100 h-100" 
                             alt="{{ $product->name }}"
                             style="object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center h-100 text-muted">
                            <i class="fas fa-image fa-3x"></i>
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div class="card-body">
                    <h5 class="card-title fw-bold text-truncate">{{ $product->name }}</h5>
                    <div class="d-flex flex-wrap gap-2 mb-2">
                        <span class="badge bg-info text-dark">{{ $product->type }}</span>
                        @if($product->category)
                            <span class="badge bg-secondary">{{ $product->category }}</span>
                        @endif
                    </div>
                    <div class="mb-2">
                        <span class="fw-semibold">Price:</span>
                        <span class="text-success">
                            @switch($product->currency)
                                @case('NGN') ₦ @break
                                @case('USD') $ @break
                                @case('GHS') GH¢ @break
                                @case('XAF') FCFA @break
                                @case('KES') KES @break
                                @default {{ $product->currency }}
                            @endswitch
                            {{ number_format($product->price, 2) }}
                        </span>
                    </div>
                    <div class="mb-2">
                        <span class="fw-semibold">Commission:</span>
                        <span class="text-primary">{{ $product->commission_percent }}%</span>
                    </div>
                    <div class="small text-muted">
                        <i class="far fa-calendar-alt me-1"></i>Added {{ $product->created_at->format('M d, Y') }}
                    </div>
                </div>

                        <!-- Card Footer with action buttons -->
                <div class="card-footer bg-white border-0 d-flex justify-content-between gap-2 pb-3 pt-0">
                    <a href="{{ route('vendor.products.edit', $product) }}" class="btn btn-outline-success flex-fill">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <form action="{{ route('vendor.products.destroy', $product) }}" method="POST" class="flex-fill" onsubmit="return confirm('Are you sure you want to delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-success w-100">
                            <i class="fas fa-trash me-1"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                <h4 class="fw-light">No products yet</h4>
                <p class="text-muted mb-4">Start by adding your first product to the marketplace.</p>
                <a href="{{ route('vendor.products.create') }}" class="btn btn-success btn-lg">
                    <i class="fas fa-plus me-2"></i>Add Your First Product
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .product-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border-radius: 0.75rem;
    }
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
    }
    .product-image-wrapper {
        background-color: #f8f9fa;
        border-radius: 0.75rem 0.75rem 0 0;
    }
</style>
@endpush