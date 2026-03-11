@extends('layouts.admin')

@section('title', 'My Profile')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="fw-bold">My Profile</h2>
        <p class="text-muted">Update your personal information</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

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
                                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                                </div>
                            @endif
                            <label for="profile_image" class="position-absolute bottom-0 end-0 bg-success rounded-circle p-2 shadow-sm" style="cursor: pointer;">
                                <i class="fas fa-camera text-white"></i>
                            </label>
                            <input type="file" id="profile_image" name="profile_image" class="d-none" accept="image/*">
                        </div>
                        <small class="text-muted d-block mt-2">Click camera to change image</small>
                    </div>

                    <!-- Profile Fields -->
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
                                <label class="form-label fw-semibold">New Password (leave blank to keep current)</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success px-5">
                        <i class="fas fa-save me-2"></i>Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview image before upload
    document.getElementById('profile_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.querySelector('.rounded-circle.border');
                if (img) {
                    img.src = e.target.result;
                } else {
                    // If no image, replace the placeholder div
                    const container = document.querySelector('.position-relative.d-inline-block');
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