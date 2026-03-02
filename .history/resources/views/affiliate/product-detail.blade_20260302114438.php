@extends('layouts.affiliate')

@section('title', $product->name . ' – Promote')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2>Product Details</h2>
        </div>
    </div>

    <!-- Top Buttons Section -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-end">
            <a href="#" class="btn btn-outline-success me-2">Payment Page</a>
            <a href="#" class="btn btn-success">Sales Page</a>
        </div>
    </div>

    <!-- Product Details Card -->
    <div class="row mb-4 mt-4">
        <div class="col-12 col-md-6 mb-4">
            <div class="card border-0 shadow-sm p-3" style="background-color: #065754; color: white;">
                <!-- Star Rating and Product Name -->
                <div class="d-flex align-items-center mb-3">
                    <div class="me-2">
                        @php
                            $rating = round($product->rating); // round to nearest whole number
                        @endphp
                        @for($i = 0; $i < $rating; $i++)
                            <i class="fas fa-star text-warning"></i>
                        @endfor
                        @for($i = $rating; $i < 5; $i++)
                            <i class="far fa-star text-warning"></i>
                        @endfor
                    </div>
                    <h4 class="mb-0">{{ $product->name }}</h4>
                </div>
            </div>
        </div>

        <div class="col-12 mt-4">
            <div class="col-12 col-md-12">
                <div class="card border-0 shadow-sm p-3 d-flex flex-column align-items-center justify-content-center" 
                    style="background-color: #065754; color: white; min-height: 150px;">
                    <!-- Scrollable Vendor Info Row -->
                    <div class="d-flex overflow-auto mb-3 justify-content-center" style="gap: 2rem;">
                        <div class="p-2 border rounded flex-shrink-0 text-center">
                            <strong style="color: #48BB78;">Vendor Name:</strong> Oyebambo
                        </div>
                        <div class="p-2 border rounded flex-shrink-0 text-center">
                            <strong style="color: #48BB78;">Sales Price:</strong> {{ $product->currency }} {{ number_format($product->price, 2) }}
                        </div>
                        <div class="p-2 border rounded flex-shrink-0 text-center">
                            <strong style="color: #48BB78;">Commission:</strong> {{ $product->commission_percent }}%
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="col-12 col-md-12">
                <div class="card border-0 shadow-sm p-3">
                    <!-- Affiliate Links -->
                    <div class="mb-3">
                        <h5>Get your affiliate link</h5>

                        @php
                            $affiliateId = auth()->id();
                            $productId = $product->id;
                            $baseUrl = 'https://aff.smartearn.com';
                        @endphp

                        <h6>Copy Affiliate Link Below 👇</h6>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" value="{{ $baseUrl }}/{{ $affiliateId }}/{{ $productId }}" readonly>
                            <button class="btn btn-outline-secondary" onclick="copyToClipboard(this)">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>

                        <h6>Copy Link for Affiliate Webinar Page below</h6>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" value="{{ $baseUrl }}/webinar/{{ $affiliateId }}/{{ $productId }}" readonly>
                            <button class="btn btn-outline-secondary" onclick="copyToClipboard(this)">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>

                        <h6>Copy Affiliate Link Payment Page below</h6>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" value="{{ $baseUrl }}/pay/{{ $affiliateId }}/{{ $productId }}" readonly>
                            <button class="btn btn-outline-secondary" onclick="copyToClipboard(this)">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-4">
            <div class="col-12 col-md-12">
                <div class="card border-0 shadow-sm p-3">
                    <h5>Vendor Information</h5>
                    <p><strong>Name:</strong> Oyebambo Moreira</p>
                    <p><strong>About me:</strong> An Ecommerce Expert</p>
                    <p><strong>Business Description:</strong> Building one of the biggest Ecommerce Education networks</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyToClipboard(button) {
    const input = button.previousElementSibling;
    input.select();
    input.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(input.value).then(() => {
        button.innerHTML = '<i class="fas fa-check"></i>';
        setTimeout(() => button.innerHTML = '<i class="fas fa-copy"></i>', 1500);
    });
}
</script>
@endpush