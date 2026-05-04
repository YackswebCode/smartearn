@extends('layouts.admin')
@section('title', 'Edit Lecture')
@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4">Edit Lecture</h2>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.lectures.update', $lecture) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Track</label>
                    <select name="track_id" class="form-control" required>
                        <option value="">-- Choose --</option>
                        @foreach($tracks as $trk)
                            <option value="{{ $trk->id }}" {{ $lecture->track_id == $trk->id ? 'selected' : '' }}>
                                {{ $trk->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $lecture->title) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" class="form-control" rows="6">{{ old('content', $lecture->content) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Video URL</label>
                    <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $lecture->video_url) }}" placeholder="YouTube embed or mp4">
                </div>
                <div class="mb-3">
                    <label class="form-label">Order</label>
                    <input type="number" name="order" class="form-control" value="{{ old('order', $lecture->order) }}">
                </div>
                <button class="btn btn-success">Update Lecture</button>
                <a href="{{ route('admin.lectures.index') }}" class="btn btn-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection