@extends('layouts.affiliate')

@section('title', 'Marketplace')

@section('content')

<!-- Payment Modal -->
<div class="modal fade items-align-center" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-header border-0 justify-content-center">
        <h5 class="modal-title" id="paymentModalLabel">Make Payment</h5>
      </div>
      <div class="modal-body">
        <p>A one-time payment must be made in order to access the Affiliate Marketplace.</p>
        <p>Lorem ipsum dolor sit amet consectetur. Sagittis eget risus.</p>
        <h4>N5,000</h4>
      </div>
      <div class="modal-footer border-0 justify-content-center">
        <a href="{{ route('affiliate.dashboard') }}" class="btn btn-outline-success">Cancel</a>
        <button type="button" class="btn btn-success" id="payNowBtn">Make Payment Now</button>
      </div>
    </div>
  </div>
</div>

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
        <div class="card h-100 border-0 shadow-sm p-3" style="background-color: #065754; color: white; ">
            
            <!-- Stars -->
            <div class="mb-2">
                @for($i=0; $i < $product->rating; $i++)
                    <i class="fas fa-star text-warning"></i>
                @endfor
            </div>

            <!-- Product Name & Category -->
            <h5>{{ $product->name }}</h5>
            <small class="text-muted">{{ $product->category }}</small>

            <!-- Button, Price, Commission on same line -->
            <div class="d-flex justify-content-between align-items-center mt-2">
                <a href="{{ route('affiliate.product.detail', ['slug' => $product->slug]) }}" class="btn btn-success btn-sm">Promote</a>
                <div>
                    <span style="font-size: 10px">NGN {{ number_format($product->price, 2) }}</span> | 
                    <span>Com: {{ $product->commission_percent }}%</span>
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

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Show payment modal on page load
    var paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
    paymentModal.show();

    // Pay Now button
    document.getElementById('payNowBtn').addEventListener('click', function() {
        paymentModal.hide();
    });
});
</script>
@endpush
