@extends('layouts.admin')
@section('title', 'Digital University - Tracks')
@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Tracks</h2>
        <a href="{{ route('admin.tracks.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Add Track
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
                        <th>Title</th>
                        <th>Faculty</th>
                        <th>Duration (mo)</th>
                        <th>Currency</th>
                        <th>Price (Base)</th>
                        <th>Active</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tracks as $track)
                    <tr>
                        <td>{{ $track->title }}</td>
                        <td>{{ $track->faculty->name ?? 'N/A' }}</td>
                        <td>{{ $track->duration_months }}</td>
                        <td>{{ $track->currency }}</td>
                        <td>{{ number_format($track->price, 2) }}</td>
                        <td>{{ $track->is_active ? '✅' : '❌' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.tracks.edit', $track) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('admin.tracks.destroy', $track) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this track?')">Delete</button>
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