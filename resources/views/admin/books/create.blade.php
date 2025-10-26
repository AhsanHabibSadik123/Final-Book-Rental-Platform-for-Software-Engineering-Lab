<!-- This page is use for adding new books to the inventory. admin can add the book details here -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Add New Book - BookStore Admin</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #556a7eff 0%, #556a7eff 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Navbar */
        .admin-navbar {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.08);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.3rem;
            color: #fff !important;
        }

        .navbar-nav .nav-link,
        .navbar-nav .dropdown-item {
            color: #fff !important;
            font-weight: 500;
        }

        .navbar-nav .dropdown-menu {
            background: #34495e;
        }

        .navbar-nav .dropdown-item:hover {
            background: #667eea;
            color: #fff !important;
        }

        /* End navbar */

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.95);
        }

        .admin-content {
            margin-top: 0;
            padding-top: 20px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg admin-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-shield-alt me-2"></i>Admin Panel
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto">
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item me-2 d-flex align-items-center">
                        <span class="badge bg-warning text-dark">
                            <i class="fas fa-wallet me-1"></i> Balance: ${{ number_format(Auth::user()->wallet ?? 0, 2) }}
                        </span>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user-edit me-2"></i>Profile
                                </a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="fas fa-home me-2"></i>User Dashboard
                                </a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="admin-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 fw-bold text-white">
                            <i class="fas fa-plus-circle me-2"></i>Add New Book
                        </h1>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.books') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left me-1"></i>  Book Management
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

                    <!-- Add Book Form -->
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-book me-2"></i>Add New Book
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <!-- Title -->
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Book Title *</label>
                                            <input type="text"
                                                class="form-control @error('title') is-invalid @enderror"
                                                id="title"
                                                name="title"
                                                value="{{ old('title') }}"
                                                placeholder="Enter book title"
                                                required>
                                            @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Author -->
                                        <div class="mb-3">
                                            <label for="author" class="form-label">Author *</label>
                                            <input type="text"
                                                class="form-control @error('author') is-invalid @enderror"
                                                id="author"
                                                name="author"
                                                value="{{ old('author') }}"
                                                placeholder="Enter author name"
                                                required>
                                            @error('author')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- ISBN -->
                                        <div class="mb-3">
                                            <label for="isbn" class="form-label">ISBN (Optional)</label>
                                            <input type="text"
                                                class="form-control @error('isbn') is-invalid @enderror"
                                                id="isbn"
                                                name="isbn"
                                                value="{{ old('isbn') }}"
                                                placeholder="Enter ISBN number">
                                            @error('isbn')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">International Standard Book Number</div>
                                        </div>

                                        <!-- Genre -->
                                        <div class="mb-3">
                                            <label for="genre" class="form-label">Genre *</label>
                                            <select class="form-select @error('genre') is-invalid @enderror"
                                                id="genre"
                                                name="genre"
                                                required>
                                                <option value="">Select a genre</option>
                                                <option value="Fiction" {{ old('genre') == 'Fiction' ? 'selected' : '' }}>Fiction</option>
                                                <option value="Non-Fiction" {{ old('genre') == 'Non-Fiction' ? 'selected' : '' }}>Non-Fiction</option>
                                                <option value="Mystery" {{ old('genre') == 'Mystery' ? 'selected' : '' }}>Mystery</option>
                                                <option value="Romance" {{ old('genre') == 'Romance' ? 'selected' : '' }}>Romance</option>
                                                <option value="Science Fiction" {{ old('genre') == 'Science Fiction' ? 'selected' : '' }}>Science Fiction</option>
                                                <option value="Fantasy" {{ old('genre') == 'Fantasy' ? 'selected' : '' }}>Fantasy</option>
                                                <option value="Educational" {{ old('genre') == 'Educational' ? 'selected' : '' }}>Educational</option>
                                                <option value="Other" {{ old('genre') == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('genre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Condition -->
                                        <div class="mb-3">
                                            <label for="condition" class="form-label">Condition *</label>
                                            <select class="form-select @error('condition') is-invalid @enderror"
                                                id="condition"
                                                name="condition"
                                                required>
                                                <option value="">Select condition</option>
                                                <option value="excellent" {{ old('condition') == 'excellent' ? 'selected' : '' }}>Excellent</option>
                                                <option value="very_good" {{ old('condition') == 'very_good' ? 'selected' : '' }}>Very Good</option>
                                                <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>Good</option>
                                                <option value="fair" {{ old('condition') == 'fair' ? 'selected' : '' }}>Fair</option>
                                            </select>
                                            @error('condition')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Rental Price -->
                                        <div class="mb-3">
                                            <label for="rental_price_per_day" class="form-label">Rental Price per Day *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number"
                                                    class="form-control @error('rental_price_per_day') is-invalid @enderror"
                                                    id="rental_price_per_day"
                                                    name="rental_price_per_day"
                                                    value="{{ old('rental_price_per_day') }}"
                                                    step="0.01"
                                                    min="0"
                                                    placeholder="0.00"
                                                    required>
                                            </div>
                                            @error('rental_price_per_day')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Security Deposit -->
                                        <div class="mb-3">
                                            <label for="security_deposit" class="form-label">Security Deposit *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number"
                                                    class="form-control @error('security_deposit') is-invalid @enderror"
                                                    id="security_deposit"
                                                    name="security_deposit"
                                                    value="{{ old('security_deposit') }}"
                                                    step="0.01"
                                                    min="0"
                                                    placeholder="0.00"
                                                    required>
                                            </div>
                                            @error('security_deposit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Description -->
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description (Optional)</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                id="description"
                                                name="description"
                                                rows="3"
                                                placeholder="Brief description of the book">{{ old('description') }}</textarea>
                                            @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Book Owner -->
                                        <div class="mb-3">
                                            <label for="lender_id" class="form-label">Book Owner (Optional)</label>
                                            <select class="form-select @error('lender_id') is-invalid @enderror"
                                                id="lender_id"
                                                name="lender_id">
                                                <option value="">Admin Added (No specific owner)</option>
                                                @foreach(App\Models\User::where('role', '!=', 'admin')->get() as $user)
                                                <option value="{{ $user->id }}" {{ old('lender_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }} ({{ $user->email }})
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('lender_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Select the user who owns this book</div>
                                        </div>

                                        <!-- Book Cover Image -->
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Book Cover Image (Optional)</label>
                                            <input type="file"
                                                class="form-control @error('image') is-invalid @enderror"
                                                id="image"
                                                name="image"
                                                accept="image/*">
                                            @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Form Actions -->
                                        <div class="d-flex justify-content-between mt-4">
                                            <a href="{{ route('admin.books') }}" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left me-1"></i> Back
                                            </a>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save me-1"></i> Add Book
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Simple image preview
                const imageInput = document.getElementById('image');

                if (imageInput) {
                    imageInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            // Simple file validation
                            const fileSize = file.size / 1024 / 1024; // Convert to MB
                            if (fileSize > 2) {
                                alert('File size must be less than 2MB');
                                this.value = '';
                            }
                        }
                    });
                }
            });
        </script>
    </div>
    @include('layouts.footer')  

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>