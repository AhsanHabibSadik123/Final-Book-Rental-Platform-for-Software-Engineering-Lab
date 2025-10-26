<!-- This page is use for edit the existing book from the database. admin can edit books info -->
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 fw-bold text-white">
                    <i class="fas fa-edit me-2"></i>Edit Book
                </h1>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.books.show', $book) }}" class="btn btn-info">
                        <i class="fas fa-eye me-1"></i> View Book
                    </a>
                    <a href="{{ route('admin.books') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Books
                    </a>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Edit Book Form -->
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-book me-2"></i>Edit Book Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data" id="editBookForm">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6">
                                        <!-- Title -->
                                        <div class="mb-3">
                                            <label for="title" class="form-label fw-bold">
                                                <i class="fas fa-heading me-1"></i>Book Title <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control @error('title') is-invalid @enderror" 
                                                   id="title" 
                                                   name="title" 
                                                   value="{{ old('title', $book->title) }}" 
                                                   placeholder="Enter book title..."
                                                   required>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Author -->
                                        <div class="mb-3">
                                            <label for="author" class="form-label fw-bold">
                                                <i class="fas fa-user-edit me-1"></i>Author <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control @error('author') is-invalid @enderror" 
                                                   id="author" 
                                                   name="author" 
                                                   value="{{ old('author', $book->author) }}" 
                                                   placeholder="Enter author name..."
                                                   required>
                                            @error('author')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- ISBN -->
                                        <div class="mb-3">
                                            <label for="isbn" class="form-label fw-bold">
                                                <i class="fas fa-barcode me-1"></i>ISBN
                                            </label>
                                            <input type="text" 
                                                   class="form-control @error('isbn') is-invalid @enderror" 
                                                   id="isbn" 
                                                   name="isbn" 
                                                   value="{{ old('isbn', $book->isbn) }}" 
                                                   placeholder="Enter ISBN (optional)...">
                                            @error('isbn')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">International Standard Book Number (optional)</div>
                                        </div>

                                        <!-- Genre -->
                                        <div class="mb-3">
                                            <label for="genre" class="form-label fw-bold">
                                                <i class="fas fa-tags me-1"></i>Genre <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('genre') is-invalid @enderror" 
                                                    id="genre" 
                                                    name="genre" 
                                                    required>
                                                <option value="">Select a genre...</option>
                                                <option value="Fiction" {{ old('genre', $book->genre) == 'Fiction' ? 'selected' : '' }}>Fiction</option>
                                                <option value="Non-Fiction" {{ old('genre', $book->genre) == 'Non-Fiction' ? 'selected' : '' }}>Non-Fiction</option>
                                                <option value="Mystery" {{ old('genre', $book->genre) == 'Mystery' ? 'selected' : '' }}>Mystery</option>
                                                <option value="Romance" {{ old('genre', $book->genre) == 'Romance' ? 'selected' : '' }}>Romance</option>
                                                <option value="Science Fiction" {{ old('genre', $book->genre) == 'Science Fiction' ? 'selected' : '' }}>Science Fiction</option>
                                                <option value="Fantasy" {{ old('genre', $book->genre) == 'Fantasy' ? 'selected' : '' }}>Fantasy</option>
                                                <option value="Biography" {{ old('genre', $book->genre) == 'Biography' ? 'selected' : '' }}>Biography</option>
                                                <option value="History" {{ old('genre', $book->genre) == 'History' ? 'selected' : '' }}>History</option>
                                                <option value="Self-Help" {{ old('genre', $book->genre) == 'Self-Help' ? 'selected' : '' }}>Self-Help</option>
                                                <option value="Business" {{ old('genre', $book->genre) == 'Business' ? 'selected' : '' }}>Business</option>
                                                <option value="Technology" {{ old('genre', $book->genre) == 'Technology' ? 'selected' : '' }}>Technology</option>
                                                <option value="Educational" {{ old('genre', $book->genre) == 'Educational' ? 'selected' : '' }}>Educational</option>
                                                <option value="Children" {{ old('genre', $book->genre) == 'Children' ? 'selected' : '' }}>Children</option>
                                                <option value="Young Adult" {{ old('genre', $book->genre) == 'Young Adult' ? 'selected' : '' }}>Young Adult</option>
                                                <option value="Other" {{ old('genre', $book->genre) == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('genre')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Condition -->
                                        <div class="mb-3">
                                            <label for="condition" class="form-label fw-bold">
                                                <i class="fas fa-star me-1"></i>Condition <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('condition') is-invalid @enderror" 
                                                    id="condition" 
                                                    name="condition" 
                                                    required>
                                                <option value="">Select condition...</option>
                                                <option value="excellent" {{ old('condition', $book->condition) == 'excellent' ? 'selected' : '' }}>
                                                    Excellent
                                                </option>
                                                <option value="very_good" {{ old('condition', $book->condition) == 'very_good' ? 'selected' : '' }}>
                                                    Very Good
                                                </option>
                                                <option value="good" {{ old('condition', $book->condition) == 'good' ? 'selected' : '' }}>
                                                    Good
                                                </option>
                                                <option value="fair" {{ old('condition', $book->condition) == 'fair' ? 'selected' : '' }}>
                                                    Fair
                                                </option>
                                            </select>
                                            @error('condition')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Status -->
                                        <div class="mb-3">
                                            <label for="status" class="form-label fw-bold">
                                                <i class="fas fa-circle-check me-1"></i>Status <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('status') is-invalid @enderror" 
                                                    id="status" 
                                                    name="status" 
                                                    required>
                                                <option value="">Select status...</option>
                                                <option value="available" {{ old('status', $book->status) == 'available' ? 'selected' : '' }}>
                                                    Available - Ready for rental
                                                </option>
                                                <option value="rented" {{ old('status', $book->status) == 'rented' ? 'selected' : '' }}>
                                                    Rented - Currently rented out
                                                </option>
                                                <option value="maintenance" {{ old('status', $book->status) == 'maintenance' ? 'selected' : '' }}>
                                                    Maintenance - Under repair/review
                                                </option>
                                                <option value="unavailable" {{ old('status', $book->status) == 'unavailable' ? 'selected' : '' }}>
                                                    Unavailable - Temporarily not available
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-6">
                                        <!-- Description -->
                                        <div class="mb-3">
                                            <label for="description" class="form-label fw-bold">
                                                <i class="fas fa-align-left me-1"></i>Description
                                            </label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                      id="description" 
                                                      name="description" 
                                                      rows="4" 
                                                      placeholder="Enter book description...">{{ old('description', $book->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Brief description of the book (optional)</div>
                                        </div>

                                        <!-- Rental Price -->
                                        <div class="mb-3">
                                            <label for="rental_price_per_day" class="form-label fw-bold">
                                                <i class="fas fa-dollar-sign me-1"></i>Rental Price per Day <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" 
                                                       class="form-control @error('rental_price_per_day') is-invalid @enderror" 
                                                       id="rental_price_per_day" 
                                                       name="rental_price_per_day" 
                                                       value="{{ old('rental_price_per_day', $book->rental_price_per_day) }}" 
                                                       step="0.01" 
                                                       min="0" 
                                                       placeholder="0.00"
                                                       required>
                                                <span class="input-group-text">/day</span>
                                            </div>
                                            @error('rental_price_per_day')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Daily rental rate for this book</div>
                                        </div>

                                        <!-- Security Deposit -->
                                        <div class="mb-3">
                                            <label for="security_deposit" class="form-label fw-bold">
                                                <i class="fas fa-shield-alt me-1"></i>Security Deposit <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" 
                                                       class="form-control @error('security_deposit') is-invalid @enderror" 
                                                       id="security_deposit" 
                                                       name="security_deposit" 
                                                       value="{{ old('security_deposit', $book->security_deposit) }}" 
                                                       step="0.01" 
                                                       min="0" 
                                                       placeholder="0.00"
                                                       required>
                                            </div>
                                            @error('security_deposit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Refundable deposit amount</div>
                                        </div>

                                        <!-- Book Owner -->
                                        <div class="mb-3">
                                            <label for="lender_id" class="form-label fw-bold">
                                                <i class="fas fa-user me-1"></i>Book Owner
                                            </label>
                                            <select class="form-select @error('lender_id') is-invalid @enderror" 
                                                    id="lender_id" 
                                                    name="lender_id">
                                                <option value="">Admin Added (No specific owner)</option>
                                                @foreach(App\Models\User::where('role', '!=', 'admin')->get() as $user)
                                                    <option value="{{ $user->id }}" {{ old('lender_id', $book->lender_id) == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }} ({{ $user->email }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('lender_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Select the user who owns this book (optional)</div>
                                        </div>

                                        <!-- Current Image -->
                                        @if($book->image_path)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-image me-1"></i>Current Cover Image
                                            </label>
                                            <div class="border rounded p-2 bg-light text-center">
                                                    <img src="{{ asset($book->image_path) }}" 
                                                     alt="{{ $book->title }}" 
                                                     class="img-fluid" 
                                                     style="max-height: 150px;">
                                            </div>
                                        </div>
                                        @endif

                                        <!-- New Book Image -->
                                        <div class="mb-3">
                                            <label for="image" class="form-label fw-bold">
                                                <i class="fas fa-upload me-1"></i>{{ $book->image_path ? 'Replace Cover Image' : 'Upload Cover Image' }}
                                            </label>
                                            <input type="file" 
                                                   class="form-control @error('image') is-invalid @enderror" 
                                                   id="image" 
                                                   name="image" 
                                                   accept="image/*">
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Upload new book cover image (JPG, PNG, GIF - Max: 2MB)</div>
                                        </div>

                                        <!-- New Image Preview -->
                                        <div class="mb-3" id="imagePreviewContainer" style="display: none;">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-eye me-1"></i>New Image Preview
                                            </label>
                                            <div class="border rounded p-2 bg-light">
                                                <img id="imagePreview" src="#" alt="New Image Preview" class="img-fluid" style="max-height: 150px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <a href="{{ route('admin.books.show', $book) }}" class="btn btn-outline-secondary">
                                                    <i class="fas fa-times me-1"></i> Cancel
                                                </a>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button type="reset" class="btn btn-outline-warning">
                                                    <i class="fas fa-undo me-1"></i> Reset Changes
                                                </button>
                                                <button type="submit" class="btn btn-warning" id="submitBtn">
                                                    <i class="fas fa-save me-1"></i> Update Book
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Form Styling */
.card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.form-control, .form-select {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    padding: 12px 16px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

.form-control.is-invalid, .form-select.is-invalid {
    border-color: #dc3545;
}

.form-control.is-invalid:focus, .form-select.is-invalid:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.form-label {
    color: #495057;
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.form-text {
    color: #6c757d;
    font-size: 0.875rem;
}

.input-group-text {
    background-color: #f8f9fa;
    border: 2px solid #e9ecef;
    color: #495057;
    font-weight: 500;
}

.btn {
    padding: 10px 20px;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Alert Styling */
.alert {
    border-radius: 10px;
    border: none;
    font-size: 0.9rem;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
}

/* Required Field Indicator */
.text-danger {
    color: #dc3545 !important;
}

/* Image Preview Styling */
#imagePreviewContainer {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Loading State */
.btn-loading {
    position: relative;
    color: transparent !important;
}

.btn-loading::after {
    content: "";
    position: absolute;
    width: 16px;
    height: 16px;
    top: 50%;
    left: 50%;
    margin-left: -8px;
    margin-top: -8px;
    border: 2px solid #495057;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .col-md-6 {
        margin-bottom: 1rem;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .d-flex.gap-2 {
        flex-direction: column;
        gap: 0.5rem !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Edit Book form loaded');
    
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreviewContainer.style.display = 'block';
            };
            
            reader.readAsDataURL(file);
        } else {
            imagePreviewContainer.style.display = 'none';
        }
    });
    
    // Form submission handling
    const form = document.getElementById('editBookForm');
    const submitBtn = document.getElementById('submitBtn');
    
    form.addEventListener('submit', function(e) {
        // Add loading state to submit button
        submitBtn.classList.add('btn-loading');
        submitBtn.disabled = true;
        
        // Set a timeout to reset the button if something goes wrong
        setTimeout(() => {
            submitBtn.classList.remove('btn-loading');
            submitBtn.disabled = false;
        }, 10000); // 10 seconds timeout
    });
    
    // Form validation feedback
    const inputs = document.querySelectorAll('.form-control, .form-select');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.value.trim()) {
                this.classList.remove('is-invalid');
            }
        });
    });
    
    console.log('Edit Book form scripts initialized');
});
</script>
@endsection
