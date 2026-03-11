@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="fw-bold">Edit User: {{ $user->name }}</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Business Name</label>
                        <input type="text" name="business_name" class="form-control"
                               value="{{ old('business_name', $user->business_name) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Currency</label>
                        <select name="currency" class="form-select @error('currency') is-invalid @enderror">
                            <option value="NGN" {{ old('currency', $user->currency) == 'NGN' ? 'selected' : '' }}>NGN</option>
                            <option value="USD" {{ old('currency', $user->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                            <option value="GHS" {{ old('currency', $user->currency) == 'GHS' ? 'selected' : '' }}>GHS</option>
                            <option value="XAF" {{ old('currency', $user->currency) == 'XAF' ? 'selected' : '' }}>XAF</option>
                            <option value="KES" {{ old('currency', $user->currency) == 'KES' ? 'selected' : '' }}>KES</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">About Me</label>
                        <textarea name="about_me" rows="3" class="form-control">{{ old('about_me', $user->about_me) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Business Description</label>
                        <textarea name="business_description" rows="3" class="form-control">{{ old('business_description', $user->business_description) }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Vendor Status</label>
                        <select name="vendor_status" class="form-select @error('vendor_status') is-invalid @enderror">
                            <option value="Not_Yet" {{ old('vendor_status', $user->vendor_status) == 'Not_Yet' ? 'selected' : '' }}>Not Yet</option>
                            <option value="Pending" {{ old('vendor_status', $user->vendor_status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Active" {{ old('vendor_status', $user->vendor_status) == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Reject" {{ old('vendor_status', $user->vendor_status) == 'Reject' ? 'selected' : '' }}>Reject</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <div class="form-check mt-4">
                            <input type="checkbox" name="activation_paid" class="form-check-input" id="activationPaid"
                                   value="1" {{ old('activation_paid', $user->activation_paid) ? 'checked' : '' }}>
                            <label class="form-check-label" for="activationPaid">Activation Paid</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-check mt-4">
                            <input type="checkbox" name="is_banned" class="form-check-input" id="isBanned"
                                   value="1" {{ old('is_banned', $user->is_banned) ? 'checked' : '' }}>
                            <label class="form-check-label" for="isBanned">Banned</label>
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success px-4">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection