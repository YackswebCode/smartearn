@extends('layouts.admin')

@section('title', $track->exists ? 'Edit Track' : 'Add Track')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4"><h2 class="fw-bold">{{ $track->exists ? 'Edit Track' : 'Add Track' }}</h2></div>
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($formMethod === 'POST' && $track->exists) @method('PUT') @endif
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Name *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $track->name) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Faculty *</label>
                        <select name="faculty_id" class="form-select" required>
                            @foreach($faculties as $f)
                                <option value="{{ $f->id }}" {{ old('faculty_id',$track->faculty_id)==$f->id?'selected':'' }}>{{ $f->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Order</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', $track->order) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Description *</label>
                        <textarea name="description" rows="3" class="form-control" required>{{ old('description', $track->description) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Detailed Explanation</label>
                        <textarea name="detailed_explanation" rows="4" class="form-control">{{ old('detailed_explanation', $track->detailed_explanation) }}</textarea>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Price Monthly</label>
                        <input type="number" step="0.01" name="price_monthly" class="form-control" value="{{ old('price_monthly', $track->price_monthly) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Price Quarterly</label>
                        <input type="number" step="0.01" name="price_quarterly" class="form-control" value="{{ old('price_quarterly', $track->price_quarterly) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Price Yearly</label>
                        <input type="number" step="0.01" name="price_yearly" class="form-control" value="{{ old('price_yearly', $track->price_yearly) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Currency</label>
                        <select name="currency" class="form-select">
                            @foreach(['NGN','USD','GHS','XAF','KES'] as $c)
                                <option value="{{ $c }}" {{ old('currency',$track->currency)==$c?'selected':'' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Image</label>
                        @if($track->image)<div><img src="{{ asset('storage/'.$track->image) }}" width="100"></div>@endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Duration (months)</label>
                        <input type="number" name="duration_months" class="form-control" value="{{ old('duration_months', $track->duration_months) }}">
                    </div>
                    <div class="col-md-3">
                        <div class="form-check mt-4">
                            <input type="checkbox" name="is_diploma" class="form-check-input" value="1" {{ old('is_diploma',$track->is_diploma)?'checked':'' }}>
                            <label class="form-check-label">Is Diploma</label>
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.tracks.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success px-5">{{ $buttonText }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection