@extends('layouts.affiliate')

@section('title', 'Marketplace')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filter Section (functional) -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('affiliate.marketplace') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <input type="text" 
                       name="search" 
                       class="form-control form-control-sm" 
                       placeholder="Search products" 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Types</option>
                    <option value="course" {{ request('type') == 'course' ? 'selected' : '' }}>Course</option>
                    <option value="ebook" {{ request('type') == 'ebook' ? 'selected' : '' }}>E-book</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <option value="E-learning" {{ request('category') == 'E-learning' ? 'selected' : '' }}>E-learning</option>
                    <option value="Business" {{ request('category') == 'Business' ? 'selected' : '' }}>Business</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-success">
                    <i class="fas fa-search me-1"></i> Filter
                </button>
                <a href="{{ route('affiliate.marketplace') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-redo-alt me-1"></i> Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Products Display -->
<div class="row">
    @forelse($products as $product)
    <div class="col-md-3 mb-4">
        <div class="card h-100 border-0 shadow-sm product-card">
            <!-- Product Image -->
            <div class="product-img-wrapper">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                    <div class="bg-secondary bg-opacity-25 d-flex align-items-center justify-content-center h-100">
                        <i class="fas fa-image fa-3x text-white-50"></i>
                    </div>
                @endif
            </div>
            <div class="card-body p-3">
                <div class="mb-2">
                    @for($i=0; $i < $product->rating; $i++)
                        <i class="fas fa-star text-warning"></i>
                    @endfor
                </div>
                <h5 class="text-truncate">{{ $product->name }}</h5>
                <small class="text-white-50">{{ $product->category }}</small>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <a href="{{ route('affiliate.product.detail', ['slug' => $product->slug]) }}" class="btn btn-success btn-sm">Promote</a>
                    <div class="text-end">
                        <span class="badge bg-light text-dark">{{ $product->currency }} {{ number_format($product->price, 2) }}</span>
                        <br>
                        <small class="text-white-50">Com: {{ $product->commission_percent }}%</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <i class="fas fa-search fa-3x text-muted mb-3"></i>
        <h5>No products found</h5>
        <p>Try adjusting your search or filters.</p>
    </div>
    @endforelse
</div>

<!-- Pagination (restyled) -->
<div class="d-flex justify-content-center mt-4">
    {{ $products->onEachSide(1)->links('pagination::bootstrap-5') }}
</div>
@endsection

@push('styles')
<style>
    /* --- Product card --- */
    .product-card {
        background-color: #065754 !important;
        color: white;
        border-radius: 12px;
        transition: transform 0.2s ease;
    }
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.2);
    }
    .product-img-wrapper {
        height: 150px;
        overflow: hidden;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }
    .product-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* --- Pagination restyling --- */
    .pagination {
        --bs-pagination-color: #065754;
        --bs-pagination-hover-color: #044d4a;
        --bs-pagination-focus-color: #044d4a;
        --bs-pagination-active-bg: #065754;
        --bs-pagination-active-border-color: #065754;
        gap: 4px;
    }
    .pagination .page-link {
        border-radius: 50%;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #dee2e6;
        font-weight: 500;
        margin: 0 2px;
    }
    .pagination .page-item.active .page-link {
        color: white;
        background-color: #065754;
        border-color: #065754;
    }
    .pagination .page-item.disabled .page-link {
        color: #adb5bd;
        pointer-events: none;
    }
</style>
@endpush