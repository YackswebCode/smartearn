@extends('layouts.admin')

@section('title', $faculty->exists ? 'Edit Faculty' : 'Add Faculty')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="fw-bold">{{ $faculty->exists ? 'Edit Faculty' : 'Add Faculty' }}</h2>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ $formAction }}" method="POST">
                @csrf
                @if($formMethod === 'POST' && $faculty->exists) @method('PUT') @endif
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Name *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $faculty->name) }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Order</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', $faculty->order) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Icon (class name)</label>
                        <input type="text" name="icon" class="form-control" value="{{ old('icon', $faculty->icon) }}" placeholder="fas fa-code">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" rows="4" class="form-control">{{ old('description', $faculty->description) }}</textarea>
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.faculties.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success px-5">{{ $buttonText }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection