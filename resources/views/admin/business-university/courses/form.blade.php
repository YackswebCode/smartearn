@extends('layouts.admin')

@section('title', $course->exists ? 'Edit Course' : 'New Course')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="fw-bold">{{ $course->exists ? 'Edit Course' : 'Create Course' }}</h2>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($formMethod === 'POST' && $course->exists) @method('PUT') @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $course->title) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Faculty</label>
                        <select name="faculty_id" class="form-select" required>
                            @foreach($faculties as $faculty)
                                <option value="{{ $faculty->id }}" {{ old('faculty_id', $course->faculty_id) == $faculty->id ? 'selected' : '' }}>{{ $faculty->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Price</label>
                        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $course->price) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Currency</label>
                        <select name="currency" class="form-select">
                            <option value="NGN" {{ old('currency', $course->currency) == 'NGN' ? 'selected' : '' }}>NGN</option>
                            <option value="USD" {{ old('currency', $course->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                            <option value="GHS" {{ old('currency', $course->currency) == 'GHS' ? 'selected' : '' }}>GHS</option>
                            <option value="XAF" {{ old('currency', $course->currency) == 'XAF' ? 'selected' : '' }}>XAF</option>
                            <option value="KES" {{ old('currency', $course->currency) == 'KES' ? 'selected' : '' }}>KES</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Instructors</label>
                        <input type="text" name="instructors" class="form-control" value="{{ old('instructors', $course->instructors) }}" placeholder="John Doe, Jane Smith" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Order</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', $course->order) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Duration (months)</label>
                        <input type="number" name="duration_months" class="form-control" value="{{ old('duration_months', $course->duration_months) }}">
                    </div>
                    <div class="col-md-4">
                        <div class="form-check mt-4">
                            <input type="checkbox" name="is_diploma" class="form-check-input" value="1" {{ old('is_diploma', $course->is_diploma) ? 'checked' : '' }}>
                            <label class="form-check-label">Diploma Course</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Image</label>
                        @if($course->image)
                            <div><img src="{{ asset('storage/'.$course->image) }}" width="100"></div>
                        @endif
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" rows="4" class="form-control" required>{{ old('description', $course->description) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Detailed Explanation</label>
                        <textarea name="detailed_explanation" rows="6" class="form-control">{{ old('detailed_explanation', $course->detailed_explanation) }}</textarea>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.business-courses.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success px-4">{{ $buttonText }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection