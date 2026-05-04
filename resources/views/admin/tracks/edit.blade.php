@extends('layouts.admin')
@section('title', 'Edit Track')
@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4">Edit Track</h2>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.tracks.update', $track) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Faculty</label>
                            <select name="faculty_id" class="form-control" required>
                                <option value="">-- Choose --</option>
                                @foreach($faculties as $fac)
                                    <option value="{{ $fac->id }}" {{ $track->faculty_id == $fac->id ? 'selected' : '' }}>
                                        {{ $fac->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $track->title) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $track->description) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Instructors</label>
                            <input type="text" name="instructors" class="form-control" value="{{ old('instructors', $track->instructors) }}" placeholder="Dr. X, Prof. Y">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control">
                            @if($track->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $track->image) }}" height="80" class="rounded">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <input type="number" step="0.1" name="rating" class="form-control" value="{{ old('rating', $track->rating) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Reviews Count</label>
                            <input type="number" name="reviews_count" class="form-control" value="{{ old('reviews_count', $track->reviews_count) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Duration (months)</label>
                            <input type="number" name="duration_months" class="form-control" value="{{ old('duration_months', $track->duration_months) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Currency</label>
                            <select name="currency" class="form-control">
                                <option value="NGN" {{ $track->currency == 'NGN' ? 'selected' : '' }}>NGN</option>
                                <option value="USD" {{ $track->currency == 'USD' ? 'selected' : '' }}>USD</option>
                                <option value="GHS" {{ $track->currency == 'GHS' ? 'selected' : '' }}>GHS</option>
                                <option value="XAF" {{ $track->currency == 'XAF' ? 'selected' : '' }}>XAF</option>
                                <option value="KES" {{ $track->currency == 'KES' ? 'selected' : '' }}>KES</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Base Price (monthly default)</label>
                            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $track->price) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Monthly Price</label>
                            <input type="number" step="0.01" name="monthly_price" class="form-control" value="{{ old('monthly_price', $track->monthly_price) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quarterly Price</label>
                            <input type="number" step="0.01" name="quarterly_price" class="form-control" value="{{ old('quarterly_price', $track->quarterly_price) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">One-Time Price</label>
                            <input type="number" step="0.01" name="one_time_price" class="form-control" value="{{ old('one_time_price', $track->one_time_price) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Order</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', $track->order) }}">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ $track->is_active ? 'checked' : '' }}>
                            <label class="form-check-label">Active</label>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success">Update Track</button>
                <a href="{{ route('admin.tracks.index') }}" class="btn btn-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection