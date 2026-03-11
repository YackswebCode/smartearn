@extends('layouts.admin')

@section('title', 'Lectures')

@push('styles')
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Lectures</h2>
        <a href="{{ route('admin.lectures.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Add New Lecture
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table id="lecturesTable" class="table table-hover align-middle nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>Order</th>
                        <th>Title</th>
                        <th>Track</th>
                        <th>Preview</th>
                        <th>Duration</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lectures as $lecture)
                    <tr>
                        <td>{{ $lecture->order }}</td>
                        <td>{{ $lecture->title }}</td>
                        <td>{{ $lecture->track->name ?? '—' }}</td>
                        <td>{{ $lecture->is_preview ? 'Yes' : 'No' }}</td>
                        <td>{{ $lecture->duration ?? '—' }} min</td>
                        <td>
                            <a href="{{ route('admin.lectures.edit', $lecture) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.lectures.destroy', $lecture) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this lecture?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
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

@push('scripts')
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script>
    $('#lecturesTable').DataTable({ order: [[0, 'asc']] });
</script>
@endpush