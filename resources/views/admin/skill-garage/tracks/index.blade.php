@extends('layouts.admin')

@section('title', 'Skill Garage - Tracks')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Tracks</h2>
        <a href="{{ route('admin.tracks.create') }}" class="btn btn-success"><i class="fas fa-plus me-2"></i>Add Track</a>
    </div>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle" id="tracksTable">
                <thead class="table-light">
                    <tr><th>Order</th><th>Image</th><th>Name</th><th>Faculty</th><th>Prices</th><th>Currency</th><th>Diploma</th><th>Actions</th></tr>
                </thead>
                <tbody>
                @foreach($tracks as $t)
                    <tr>
                        <td>{{ $t->order }}</td>
                        <td>
                            @if($t->image)<img src="{{ asset('storage/'.$t->image) }}" width="50">@endif
                        </td>
                        <td>{{ $t->name }}</td>
                        <td>{{ $t->faculty->name }}</td>
                        <td>M:{{ $t->price_monthly }} Q:{{ $t->price_quarterly }} Y:{{ $t->price_yearly }}</td>
                        <td>{{ $t->currency }}</td>
                        <td>@if($t->is_diploma)<span class="badge bg-success">Yes</span>@else No @endif</td>
                        <td>
                            <a href="{{ route('admin.tracks.edit', $t) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.tracks.destroy', $t) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this track?')">
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
<script>$(document).ready(function(){ $('#tracksTable').DataTable({ order:[[0,'asc']] }); });</script>
@endpush