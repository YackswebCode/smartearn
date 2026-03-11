@extends('layouts.admin')

@section('title', 'Vendor Details')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Vendor Details</h2>
        <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Vendors
        </a>
    </div>

    <div class="row">
        <!-- Profile Card -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    @if($vendor->profile_image)
                        <img src="{{ asset('storage/'.$vendor->profile_image) }}" alt="Profile" class="rounded-circle mb-3" style="width:120px;height:120px;object-fit:cover;">
                    @else
                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white mx-auto mb-3" style="width:120px;height:120px;font-size:3rem;">
                            {{ strtoupper(substr($vendor->name, 0, 1)) }}
                        </div>
                    @endif
                    <h4>{{ $vendor->name }}</h4>
                    <p class="text-muted">{{ $vendor->email }}</p>
                    <p><strong>Business:</strong> {{ $vendor->business_name ?? 'N/A' }}</p>
                    <p><strong>Currency:</strong> {{ $vendor->currency }}</p>
                    <p><strong>Status:</strong>
                        @php
                            $badge = match($vendor->vendor_status) {
                                'Active' => 'bg-success',
                                'Pending' => 'bg-warning',
                                'Reject' => 'bg-danger',
                                default => 'bg-secondary'
                            };
                        @endphp
                        <span class="badge {{ $badge }}">{{ $vendor->vendor_status }}</span>
                    </p>
                    @if($vendor->vendor_status === 'Pending')
                        <div class="mt-3">
                            <form action="{{ route('admin.vendors.approve', $vendor) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check me-2"></i>Approve
                                </button>
                            </form>
                            <form action="{{ route('admin.vendors.reject', $vendor) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Reject this vendor?')">
                                    <i class="fas fa-times me-2"></i>Reject
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stats & Info -->
        <div class="col-md-8 mb-4">
            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted">Total Sales</h6>
                            <h3>{{ $vendor->currency }} {{ number_format($totalSales, 2) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted">Total Earnings</h6>
                            <h3>{{ $vendor->currency }} {{ number_format($totalEarnings, 2) }}</h3>
                        </div>
                    </div>
                </div>
               <div class="col-sm-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Products</h6>
                        <h3>{{ $vendor->products_count }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Orders</h6>
                        <h3>{{ $vendor->orders_count }}</h3>
                    </div>
                </div>
            </div>
            </div>

            <!-- About & Business Description -->
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    <h5>About Me</h5>
                    <p>{{ $vendor->about_me ?? 'No information provided.' }}</p>
                    <hr>
                    <h5>Business Description</h5>
                    <p>{{ $vendor->business_description ?? 'No description provided.' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Recent Products</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Commission</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" width="40" height="40" style="object-fit: cover;">
                            @else
                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="width:40px;height:40px;">N/A</div>
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->currency }} {{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->commission_percent }}%</td>
                        <td>{{ $product->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">No products found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Recent Orders</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Reference</th>
                        <th>Buyer</th>
                        <th>Product</th>
                        <th>Amount</th>
                        <th>Commission</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->reference }}</td>
                        <td>{{ $order->buyer_name }}</td>
                        <td>{{ $order->product->name ?? 'N/A' }}</td>
                        <td>{{ $order->currency }} {{ number_format($order->amount, 2) }}</td>
                        <td>{{ $order->currency }} {{ number_format($order->affiliate_commission, 2) }}</td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">No orders found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection