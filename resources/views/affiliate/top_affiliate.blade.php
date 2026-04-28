@extends('layouts.affiliate')

@section('title', 'Affiliate Leaderboard')

@section('content')
<div class="container-fluid py-4">
    <!-- Header & Filter -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Affiliate Leaderboard</h2>
            <p class="text-muted">Top performing affiliates this month</p>
        </div>

        {{-- Filter: Single Product vs All Products --}}
        <form method="GET" action="{{ route('affiliate.top_affiliate') }}" class="d-flex align-items-center gap-2">
            <select name="product_id" class="form-select" style="width: 220px;" onchange="this.form.submit()">
                <option value="">All Products</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ isset($productId) && $productId == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
            @if(!empty($productId))
                <a href="{{ route('affiliate.top_affiliate') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-times"></i> Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Leaderboard Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="leaderboard-table" class="table table-hover align-middle">
                    <thead class="table-success" style="background-color: #48BB78; color: white;">
                        <tr>
                            <th>Rank</th>
                            <th>Affiliate Name</th>
                            <th>Product</th>
                            <th>Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaderboard as $affiliate)
                        <tr>
                            <td>
                                @if($affiliate['position'] <= 3)
                                    <span class="badge bg-warning text-dark">#{{ $affiliate['position'] }}</span>
                                @else
                                    #{{ $affiliate['position'] }}
                                @endif
                            </td>
                            <td class="fw-bold">{{ $affiliate['name'] }}</td>
                            <td>{{ $affiliate['product_name'] }}</td>
                            <td>{{ $affiliate['sales'] }}</td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#leaderboard-table').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            pageLength: 10,
            lengthChange: false,
            autoWidth: false,
            scrollX: true,
            language: {
                paginate: {
                    previous: "Previous",
                    next: "Next"
                }
            }
        });
    });
</script>
@endpush