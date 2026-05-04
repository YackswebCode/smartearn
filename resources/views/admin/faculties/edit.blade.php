@extends('layouts.admin')
@section('title', 'Edit Faculty')
@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4">Edit Faculty</h2>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.faculties.update', $faculty) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $faculty->name) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Icon (FontAwesome class)</label>
                    <input type="text" name="icon" class="form-control" value="{{ old('icon', $faculty->icon) }}" placeholder="fa-laptop-code">
                </div>
                <div class="mb-3">
                    <label class="form-label">Order</label>
                    <input type="number" name="order" class="form-control" value="{{ old('order', $faculty->order) }}">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ $faculty->is_active ? 'checked' : '' }}>
                    <label class="form-check-label">Active</label>
                </div>
                <button class="btn btn-success">Update Faculty</button>
                <a href="{{ route('admin.faculties.index') }}" class="btn btn-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection