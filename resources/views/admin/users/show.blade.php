@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<div class="container-fluid py-4">
    <!-- Header with back button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">User Details</h2>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Users
        </a>
    </div>

    <!-- Main card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <!-- Profile Header -->
            <div class="d-flex flex-column flex-md-row align-items-center gap-4 mb-4">
                <div class="position-relative">
                    <img src="{{ $user->profile_image ? asset('storage/'.$user->profile_image) : 'https://via.placeholder.com/150' }}"
                         alt="{{ $user->name }}"
                         class="rounded-circle border"
                         style="width: 120px; height: 120px; object-fit: cover;">
                </div>
                <div class="text-center text-md-start">
                    <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                        @if($user->vendor_status === 'Active')
                            <span class="badge bg-success">Vendor</span>
                        @elseif($user->vendor_status === 'Pending')
                            <span class="badge bg-warning">Pending Vendor</span>
                        @else
                            <span class="badge bg-secondary">Affiliate</span>
                        @endif

                        @if($user->activation_paid)
                            <span class="badge bg-success">Activation Paid</span>
                        @else
                            <span class="badge bg-warning">Activation Pending</span>
                        @endif

                        @if($user->is_banned)
                            <span class="badge bg-danger">Banned</span>
                        @else
                            <span class="badge bg-success">Active</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Balance Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="fas fa-wallet fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Wallet Balance</h6>
                                    <h4 class="fw-bold mb-0">{{ $user->currency }} {{ number_format($user->wallet_balance, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="fas fa-hand-holding-usd fa-2x text-success"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Affiliate Balance</h6>
                                    <h4 class="fw-bold mb-0">{{ $user->currency }} {{ number_format($user->affiliate_balance, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-info bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="fas fa-store fa-2x text-info"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Vendor Balance</h6>
                                    <h4 class="fw-bold mb-0">{{ $user->currency }} {{ number_format($user->vendor_balance, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Information -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Personal Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted">Business Name:</td>
                                    <td class="fw-semibold">{{ $user->business_name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Currency:</td>
                                    <td class="fw-semibold">{{ $user->currency }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Joined:</td>
                                    <td class="fw-semibold">{{ $user->created_at->format('F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Email Verified:</td>
                                    <td class="fw-semibold">{{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y') : 'No' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Account Status</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted">Vendor Status:</td>
                                    <td class="fw-semibold">{{ $user->vendor_status }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Marketplace Subscribed:</td>
                                    <td class="fw-semibold">{{ $user->marketplace_subscribed ? 'Yes' : 'No' }}</td>
                                </tr>
                                @if($user->subscription_expires_at)
                                <tr>
                                    <td class="text-muted">Subscription Expires:</td>
                                    <td class="fw-semibold">{{ $user->subscription_expires_at->format('M d, Y') }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="text-muted">Activation Paid:</td>
                                    <td class="fw-semibold">{{ $user->activation_paid ? 'Yes' : 'No' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Banned:</td>
                                    <td class="fw-semibold">{{ $user->is_banned ? 'Yes' : 'No' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">About Me</h5>
                            <p>{{ $user->about_me ?? 'No information provided.' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Business Description</h5>
                            <p>{{ $user->business_description ?? 'No information provided.' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit User
                </a>
                <form action="{{ route('admin.users.ban', $user) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-{{ $user->is_banned ? 'success' : 'danger' }}">
                        <i class="fas fa-{{ $user->is_banned ? 'check' : 'ban' }} me-2"></i>
                        {{ $user->is_banned ? 'Unban User' : 'Ban User' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection