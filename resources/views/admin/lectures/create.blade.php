@extends('layouts.admin')
@section('title', 'Add Lecture')
@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4">Add Lecture</h2>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.lectures.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Track</label>
                    <select name="track_id" class="form-control" required>
                        <option value="">-- Choose --</option>
                        @foreach($tracks as $track)
                            <option value="{{ $track->id }}">{{ $track->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" class="form-control" rows="6"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Video URL</label>
                    <input type="url" name="video_url" class="form-control" placeholder="YouTube embed or mp4">
                </div>
                <div class="mb-3">
                    <label class="form-label">Order</label>
                    <input type="number" name="order" class="form-control" value="0">
                </div>
                <button class="btn btn-success">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection