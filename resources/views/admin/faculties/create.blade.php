@extends('layouts.admin')
@section('title', 'Add Faculty')
@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4">Add Faculty</h2>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.faculties.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Icon (FontAwesome class)</label>
                    <input type="text" name="icon" class="form-control" placeholder="fa-laptop-code">
                </div>
                <div class="mb-3">
                    <label class="form-label">Order</label>
                    <input type="number" name="order" class="form-control" value="0">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" value="1" checked>
                    <label class="form-check-label">Active</label>
                </div>
                <button class="btn btn-success">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection