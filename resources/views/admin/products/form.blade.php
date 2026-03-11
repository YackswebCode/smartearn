@extends('layouts.admin')

@section('title', $product->exists ? 'Edit Product' : 'Add New Product')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="mb-4">
        <h2 class="fw-bold">{{ $product->exists ? 'Edit Product' : 'Add New Product' }}</h2>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf
                @if($formMethod === 'POST' && $product->exists)
                    @method('PUT')
                @endif

                <div class="row g-4">
                    <!-- Left Column: Product Details -->
                    <div class="col-lg-7">
                        <div class="row g-3">
                            <!-- Product Name -->
                            <div class="col-md-12">
                                <label for="name" class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" placeholder="e.g., Advanced Web Development Masterclass" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Vendor Selection (admin only) -->
                            <div class="col-md-12">
                                <label for="vendor_id" class="form-label fw-semibold">Vendor (optional)</label>
                                <select class="form-select @error('vendor_id') is-invalid @enderror" id="vendor_id" name="vendor_id">
                                    <option value="">-- Platform Product (No Vendor) --</option>
                                    @foreach($vendors as $vendor)
                                        <option value="{{ $vendor->id }}" {{ old('vendor_id', $product->vendor_id) == $vendor->id ? 'selected' : '' }}>
                                            {{ $vendor->business_name ?? $vendor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('vendor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Product Type and Category -->
                            <div class="col-md-6">
                                <label for="type" class="form-label fw-semibold">Product Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="" disabled {{ old('type', $product->type) ? '' : 'selected' }}>Select product type</option>
                                    <option value="Course" {{ old('type', $product->type) == 'Course' ? 'selected' : '' }}>Course</option>
                                    <option value="Ebook" {{ old('type', $product->type) == 'Ebook' ? 'selected' : '' }}>Ebook</option>
                                    <option value="Template" {{ old('type', $product->type) == 'Template' ? 'selected' : '' }}>Template</option>
                                    <option value="Software" {{ old('type', $product->type) == 'Software' ? 'selected' : '' }}>Software</option>
                                    <option value="Media" {{ old('type', $product->type) == 'Media' ? 'selected' : '' }}>Media</option>
                                    <option value="Service" {{ old('type', $product->type) == 'Service' ? 'selected' : '' }}>Service</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="category" class="form-label fw-semibold">Category</label>
                                <select class="form-select @error('category') is-invalid @enderror" id="category" name="category">
                                    <option value="" {{ old('category', $product->category) ? '' : 'selected' }}>Select category (optional)</option>
                                    <option value="Web Development" {{ old('category', $product->category) == 'Web Development' ? 'selected' : '' }}>Web Development</option>
                                    <option value="Marketing" {{ old('category', $product->category) == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                    <option value="Design" {{ old('category', $product->category) == 'Design' ? 'selected' : '' }}>Design</option>
                                    <option value="Business" {{ old('category', $product->category) == 'Business' ? 'selected' : '' }}>Business</option>
                                    <option value="Photography" {{ old('category', $product->category) == 'Photography' ? 'selected' : '' }}>Photography</option>
                                    <option value="Music" {{ old('category', $product->category) == 'Music' ? 'selected' : '' }}>Music</option>
                                    <option value="Writing" {{ old('category', $product->category) == 'Writing' ? 'selected' : '' }}>Writing</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" placeholder="Describe your product...">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Price, Currency, Commission -->
                            <div class="col-md-4">
                                <label for="price" class="form-label fw-semibold">Price <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" id="price-symbol">
                                        @if(old('currency', $product->currency) == 'NGN') ₦
                                        @elseif(old('currency', $product->currency) == 'USD') $
                                        @elseif(old('currency', $product->currency) == 'GHS') GH¢
                                        @elseif(old('currency', $product->currency) == 'XAF') FCFA
                                        @elseif(old('currency', $product->currency) == 'KES') KES
                                        @else ₦
                                        @endif
                                    </span>
                                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="currency" class="form-label fw-semibold">Currency <span class="text-danger">*</span></label>
                                <select class="form-select @error('currency') is-invalid @enderror" id="currency" name="currency" required>
                                    <option value="NGN" {{ old('currency', $product->currency) == 'NGN' ? 'selected' : '' }}>NGN (₦)</option>
                                    <option value="USD" {{ old('currency', $product->currency) == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                    <option value="GHS" {{ old('currency', $product->currency) == 'GHS' ? 'selected' : '' }}>GHS (GH¢)</option>
                                    <option value="XAF" {{ old('currency', $product->currency) == 'XAF' ? 'selected' : '' }}>XAF (FCFA)</option>
                                    <option value="KES" {{ old('currency', $product->currency) == 'KES' ? 'selected' : '' }}>KES (KES)</option>
                                </select>
                                @error('currency')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="commission_percent" class="form-label fw-semibold">Commission (%) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('commission_percent') is-invalid @enderror" id="commission_percent" name="commission_percent" value="{{ old('commission_percent', $product->commission_percent) }}" min="0" max="100" required>
                                    <span class="input-group-text">%</span>
                                </div>
                                @error('commission_percent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Image Upload -->
                    <div class="col-lg-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body">
                                <label class="form-label fw-semibold mb-3">Product Image</label>
                                
                                <!-- Drag & Drop Area -->
                                <div id="drop-area" class="border border-2 border-dashed rounded-3 p-4 text-center bg-white mb-3" style="border-color: #ced4da; cursor: pointer;">
                                    <input type="file" id="image" name="image" accept="image/*" class="d-none">
                                    <div id="upload-preview" class="{{ $product->image ? '' : 'd-none' }}">
                                        <img id="preview-img" src="{{ $product->image ? asset('storage/' . $product->image) : '#' }}" alt="Preview" class="img-fluid rounded mb-2" style="max-height: 200px;">
                                        <button type="button" id="remove-image" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-times me-1"></i>Remove
                                        </button>
                                    </div>
                                    <div id="upload-placeholder" class="{{ $product->image ? 'd-none' : '' }}">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                        <h6 class="fw-semibold">Drag & drop an image here</h6>
                                        <p class="text-muted small mb-2">or click to browse</p>
                                        <p class="text-muted small mb-0">Supported: JPEG, PNG, JPG, GIF (Max 2MB)</p>
                                    </div>
                                </div>

                                @error('image')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror

                                <!-- Existing image info (if any) -->
                                @if($product->image)
                                    <div class="alert alert-info small py-2 mb-0">
                                        <i class="fas fa-info-circle me-1"></i> Current image: {{ basename($product->image) }}. Upload a new one to replace.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-success px-5">
                        <i class="fas fa-check me-2"></i>{{ $buttonText }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .border-dashed {
        border-style: dashed !important;
    }
    #drop-area {
        transition: border-color 0.2s, background-color 0.2s;
    }
    #drop-area.highlight {
        border-color: #198754;
        background-color: #f0f9f0;
    }
    #upload-preview img {
        max-width: 100%;
        height: auto;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('image');
        const uploadPlaceholder = document.getElementById('upload-placeholder');
        const uploadPreview = document.getElementById('upload-preview');
        const previewImg = document.getElementById('preview-img');
        const removeBtn = document.getElementById('remove-image');

        // Currency symbol update
        const currencySelect = document.getElementById('currency');
        const priceSymbol = document.getElementById('price-symbol');
        currencySelect.addEventListener('change', function() {
            const currency = this.value;
            let symbol = '₦';
            if (currency === 'USD') symbol = '$';
            else if (currency === 'GHS') symbol = 'GH¢';
            else if (currency === 'XAF') symbol = 'FCFA';
            else if (currency === 'KES') symbol = 'KES';
            priceSymbol.textContent = symbol;
        });

        // Drag & drop handlers
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            dropArea.classList.add('highlight');
        }

        function unhighlight() {
            dropArea.classList.remove('highlight');
        }

        // Handle dropped files
        dropArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            handleFiles(files);
        }

        // Click to browse
        dropArea.addEventListener('click', function() {
            fileInput.click();
        });

        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        uploadPlaceholder.classList.add('d-none');
                        uploadPreview.classList.remove('d-none');
                    }
                    reader.readAsDataURL(file);
                } else {
                    alert('Please select an image file.');
                }
            }
        }

        // Remove image
        if (removeBtn) {
            removeBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                fileInput.value = '';
                uploadPreview.classList.add('d-none');
                uploadPlaceholder.classList.remove('d-none');
            });
        }
    });
</script>
@endpush