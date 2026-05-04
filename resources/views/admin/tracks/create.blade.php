@extends('layouts.admin')
@section('title', 'Add Track')
@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4">Add Track</h2>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.tracks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Faculty</label>
                            <select name="faculty_id" class="form-control" required>
                                <option value="">-- Choose --</option>
                                @foreach($faculties as $fac)
                                    <option value="{{ $fac->id }}">{{ $fac->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Instructors</label>
                            <input type="text" name="instructors" class="form-control" placeholder="Dr. X, Prof. Y">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <input type="number" step="0.1" name="rating" class="form-control" value="4.5">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Reviews Count</label>
                            <input type="number" name="reviews_count" class="form-control" value="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Duration (months)</label>
                            <input type="number" name="duration_months" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Currency</label>
                            <select name="currency" class="form-control">
                                <option value="NGN">NGN</option>
                                <option value="USD">USD</option>
                                <option value="GHS">GHS</option>
                                <option value="XAF">XAF</option>
                                <option value="KES">KES</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Base Price (monthly default)</label>
                            <input type="number" step="0.01" name="price" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Monthly Price</label>
                            <input type="number" step="0.01" name="monthly_price" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quarterly Price</label>
                            <input type="number" step="0.01" name="quarterly_price" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">One-Time Price</label>
                            <input type="number" step="0.01" name="one_time_price" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Order</label>
                            <input type="number" name="order" class="form-control" value="0">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" value="1" checked>
                            <label class="form-check-label">Active</label>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection