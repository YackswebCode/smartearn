@extends('layouts.admin')

@section('title', 'Business Courses')

@push('styles')
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Business Courses</h2>
        <a href="{{ route('admin.business-courses.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Add Course
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table id="coursesTable" class="table table-hover align-middle nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>Order</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Faculty</th>
                        <th>Price</th>
                        <th>Instructors</th>
                        <th>Diploma</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                    <tr>
                        <td>{{ $course->order }}</td>
                        <td>@if($course->image)<img src="{{ asset('storage/'.$course->image) }}" width="50" height="50" style="object-fit: cover;">@else — @endif</td>
                        <td>{{ $course->title }}</td>
                        <td>{{ $course->faculty->name ?? '—' }}</td>
                        <td>{{ $course->currency }} {{ number_format($course->price, 2) }}</td>
                        <td>{{ $course->instructors }}</td>
                        <td>{{ $course->is_diploma ? 'Yes' : 'No' }}</td>
                        <td>
                            <a href="{{ route('admin.business-courses.edit', $course) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.business-courses.destroy', $course) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this course?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
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
    $('#coursesTable').DataTable({ order: [[0, 'asc']] });
</script>
@endpush