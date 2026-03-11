@extends('layouts.admin')

@section('title', 'Business Faculties')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Business Faculties</h2>
        <a href="{{ route('admin.business-faculties.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Add Faculty
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
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Order</th>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($faculties as $faculty)
                    <tr>
                        <td>{{ $faculty->order }}</td>
                        <td>@if($faculty->icon)<i class="{{ $faculty->icon }}"></i>@else — @endif</td>
                        <td>{{ $faculty->name }}</td>
                        <td>{{ Str::limit($faculty->description, 50) }}</td>
                        <td>
                            <a href="{{ route('admin.business-faculties.edit', $faculty) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.business-faculties.destroy', $faculty) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this faculty?')">
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