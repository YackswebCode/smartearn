@extends('layouts.affiliate')

@section('title', $product->name . ' – Promote')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h2>Product Details</h2>
        </div>
    </div>

    <!-- Top Buttons -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-end">

            {{-- 🔥 Creator Payment Page --}}
            <a href="{{ url('/p/' . $product->slug) }}" class="btn btn-outline-success me-2">
                Payment Page
            </a>

             @php
                    $affiliateId = auth()->id();

                 
                    $affiliateLinksales = route('affiliate.product.public', [
                        'affiliateId' => $affiliateId,
                        'productSlug' => $product->slug
                    ]);

                @endphp

            {{-- 🔥 Sales Page (Affiliate dashboard analytics) --}}
            <a href="{{  $affiliateLinksales }}" class="btn btn-success">
                Sales Page
            </a>
        </div>
    </div>

    <!-- Product Info -->
    <div class="row g-4 mb-4">

        <!-- Image -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div style="height:250px;overflow:hidden;border-radius:8px;">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}"
                             class="w-100 h-100"
                             style="object-fit:cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center h-100">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Name -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100 p-4 text-white"
                 style="background:#065754;">

                <div class="d-flex align-items-center mb-3">

                    @php $rating = round($product->rating); @endphp

                    <div class="me-2">
                        @for($i=1;$i<=5;$i++)
                            <i class="fa{{ $i <= $rating ? 's' : 'r' }} fa-star text-warning"></i>
                        @endfor
                    </div>

                    <h4 class="mb-0">{{ $product->name }}</h4>
                </div>

                <p>{{ $product->description }}</p>
            </div>
        </div>
    </div>

    <!-- Vendor Info -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm p-3 text-white"
                 style="background:#065754;">

                <div class="row text-center">

                    <div class="col-md-4">
                        <strong style="color:#48BB78;">Vendor:</strong><br>
                       {{ $product->vendor->name ?? 'Unknown Vendor' }}
                    </div>

                    <div class="col-md-4">
                        <strong style="color:#48BB78;">Price:</strong><br>
                        {{ $product->currency }} {{ number_format($product->price,2) }}
                    </div>

                    <div class="col-md-4">
                        <strong style="color:#48BB78;">Commission:</strong><br>
                        {{ $product->commission_percent }}%
                    </div>

                </div>
            </div>
        </div>
    </div>

    <hr>

    <!-- 🔥 AFFILIATE LINKS -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm p-3">

                <h5>Affiliate Links</h5>

                @php
                    $affiliateId = auth()->id();

                    // Affiliate link (tracked)
                    $affiliateLink = route('affiliate.product.public', [
                        'affiliateId' => $affiliateId,
                        'productSlug' => $product->slug
                    ]);

                    // Creator link (direct vendor sales)
                    $creatorLink = url('/p/' . $product->slug . '?ref=creator_' . $product->vendor_id);

                    // Payment link
                    $paymentLink = url('/p/' . $product->slug);
                @endphp

                <!-- Affiliate Link -->
                <h6>Affiliate Link</h6>
                <div class="input-group mb-3">
                    <input class="form-control" value="{{ $affiliateLink }}" readonly>
                    <button class="btn btn-outline-secondary" onclick="copy(this)">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>

                <!-- Creator Link -->
                <h6>Creator Sales Link</h6>
                <div class="input-group mb-3">
                    <input class="form-control" value="{{ $creatorLink }}" readonly>
                    <button class="btn btn-outline-secondary" onclick="copy(this)">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>

                <!-- Payment Page -->
                <!-- <h6>Payment Page Link</h6>
                <div class="input-group mb-3">
                    <input class="form-control" value="{{ $paymentLink }}" readonly>
                    <button class="btn btn-outline-secondary" onclick="copy(this)">
                        <i class="fas fa-copy"></i>
                    </button>
                </div> -->

            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function copy(btn){
    const input = btn.previousElementSibling;
    input.select();
    navigator.clipboard.writeText(input.value);
    btn.innerHTML = '<i class="fas fa-check"></i>';
    setTimeout(()=>btn.innerHTML='<i class="fas fa-copy"></i>',1500);
}
</script>
@endpush