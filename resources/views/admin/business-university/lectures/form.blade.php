@extends('layouts.admin')

@section('title', $lecture->exists ? 'Edit Lecture' : 'New Lecture')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="fw-bold">{{ $lecture->exists ? 'Edit Lecture' : 'Create Lecture' }}</h2>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ $formAction }}" method="POST">
                @csrf
                @if($formMethod === 'POST' && $lecture->exists) @method('PUT') @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $lecture->title) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Course</label>
                        <select name="course_id" class="form-select" required>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id', $lecture->course_id) == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Order</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', $lecture->order) }}">
                    </div>
                    <div class="col-md-4">
                        <div class="form-check mt-4">
                            <input type="checkbox" name="is_preview" class="form-check-input" value="1" {{ old('is_preview', $lecture->is_preview) ? 'checked' : '' }}>
                            <label class="form-check-label">Preview (free)</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Video URL</label>
                        <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $lecture->video_url) }}" placeholder="https://..." required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" rows="4" class="form-control">{{ old('description', $lecture->description) }}</textarea>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.business-lectures.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success px-4">{{ $buttonText }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection