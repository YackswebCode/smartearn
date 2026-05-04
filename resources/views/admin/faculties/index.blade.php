@extends('layouts.admin')
@section('title', 'Digital University - Faculties')
@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Faculties</h2>
        <a href="{{ route('admin.faculties.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Add Faculty
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
                        <th>Name</th>
                        <th>Icon</th>
                        <th>Order</th>
                        <th>Active</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($faculties as $faculty)
                    <tr>
                        <td>{{ $faculty->name }}</td>
                        <td><i class="fas {{ $faculty->icon }}"></i> {{ $faculty->icon }}</td>
                        <td>{{ $faculty->order }}</td>
                        <td>{{ $faculty->is_active ? '✅' : '❌' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.faculties.edit', $faculty) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('admin.faculties.destroy', $faculty) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this faculty?')">Delete</button>
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