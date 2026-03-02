@extends('layouts.affiliate')

@section('title', 'Marketplace')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filter Section -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body d-flex flex-wrap gap-2 align-items-center">
        <input type="text" class="form-control form-control-sm" placeholder="Search" style="width:150px;">
        <select class="form-select form-select-sm" style="width:150px;">
            <option value="">All Types</option>
            <option value="course">Course</option>
            <option value="ebook">E-book</option>
        </select>
        <select class="form-select form-select-sm" style="width:150px;">
            <option value="">All Categories</option>
            <option value="E-learning">E-learning</option>
            <option value="Business">Business</option>
        </select>
    </div>
</div>

<!-- Products Display -->
<div class="row">
    @foreach($products as $product)
    <div class="col-md-3 mb-4">
        <div class="card h-100 border-0 shadow-sm p-3" style="background-color: #065754; color: white;">
            <div class="mb-2">
                @for($i=0; $i < $product->rating; $i++)
                    <i class="fas fa-star text-warning"></i>
                @endfor
            </div>
            <h5>{{ $product->name }}</h5>
            <small class="text-white">{{ $product->category }}</small>
            <div class="d-flex justify-content-between align-items-center mt-2">
                <a href="{{ route('affiliate.product.detail', ['slug' => $product->slug]) }}" class="btn btn-success btn-sm">Promote</a>
                <div>
                    <span style="font-size: 10px">{{ $product->currency }} {{ number_format($product->price, 2) }} | Com: {{ $product->commission_percent }}%</span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center">
    {{ $products->links() }}
</div>
@endsection