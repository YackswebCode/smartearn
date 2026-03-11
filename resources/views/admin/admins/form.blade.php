@extends('layouts.admin')

@section('title', $admin->exists ? 'Edit Admin' : 'New Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="fw-bold">{{ $admin->exists ? 'Edit Admin' : 'Create New Admin' }}</h2>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($formMethod === 'POST' && $admin->exists)
                    @method('PUT')
                @endif

                <div class="row">
                    <!-- Profile Image -->
                    <div class="col-md-3 text-center mb-4">
                        <div class="position-relative d-inline-block">
                            @if($admin->profile_image)
                                <img src="{{ asset('storage/' . $admin->profile_image) }}" 
                                     alt="Profile" 
                                     class="rounded-circle border" 
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white mx-auto" 
                                     style="width: 150px; height: 150px; font-size: 3rem;">
                                    {{ $admin->exists ? strtoupper(substr($admin->name, 0, 1)) : 'A' }}
                                </div>
                            @endif
                            <label for="profile_image" class="position-absolute bottom-0 end-0 bg-success rounded-circle p-2 shadow-sm" style="cursor: pointer;">
                                <i class="fas fa-camera text-white"></i>
                            </label>
                            <input type="file" id="profile_image" name="profile_image" class="d-none" accept="image/*">
                        </div>
                        <small class="text-muted d-block mt-2">Click camera to upload</small>
                    </div>

                    <!-- Fields -->
                    <div class="col-md-9">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">{{ $admin->exists ? 'New Password (leave blank to keep)' : 'Password' }}</label>
                                <input type="password" name="password" class="form-control" {{ $admin->exists ? '' : 'required' }}>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" {{ $admin->exists ? '' : 'required' }}>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success px-5">{{ $buttonText }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('profile_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.querySelector('.rounded-circle.border');
                const container = document.querySelector('.position-relative.d-inline-block');
                if (img) {
                    img.src = e.target.result;
                } else {
                    container.innerHTML = `
                        <img src="${e.target.result}" alt="Profile" class="rounded-circle border" style="width: 150px; height: 150px; object-fit: cover;">
                        <label for="profile_image" class="position-absolute bottom-0 end-0 bg-success rounded-circle p-2 shadow-sm" style="cursor: pointer;">
                            <i class="fas fa-camera text-white"></i>
                        </label>
                    `;
                }
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush