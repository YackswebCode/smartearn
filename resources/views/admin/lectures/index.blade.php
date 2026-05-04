@extends('layouts.admin')
@section('title', 'Digital University - Lectures')
@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Lectures</h2>
        <a href="{{ route('admin.lectures.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Add Lecture
        </a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Track</th>
                        <th>Title</th>
                        <th>Order</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lectures as $lecture)
                    <tr>
                        <td>{{ $lecture->track->title ?? 'N/A' }}</td>
                        <td>{{ $lecture->title }}</td>
                        <td>{{ $lecture->order }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.lectures.edit', $lecture) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('admin.lectures.destroy', $lecture) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection