<!-- This page is for see the all books that the user give for rent. -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Books - {{ config('app.name', 'BookStore') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Keep only background and navbar styles */
        body {
            background: linear-gradient(135deg, #556a7eff 0%, #556a7eff 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

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
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg admin-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-book me-2"></i>BookStore
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
                            <li><a class="dropdown-item" href="{{ route('books.index') }}">
                                    <i class="fas fa-book me-2"></i>View My Books
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

    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="fw-bold text-white mb-1"><i class="fas fa-book me-2"></i>My Books</h1>
                <p class="lead text-light">All books you are lending</p>
            </div>
        </div>


        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Search and Filter -->
        <div class="bg-white rounded shadow-sm border p-4 mb-4">
            <form action="{{ route('books.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label for="search" class="form-label">Search Books</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control" placeholder="Search by title, author, genre...">
                    </div>
                    <div class="col-md-4">
                        <label for="category" class="form-label">Category</label>
                        <select name="category" id="category" class="form-select">
                            <option value="">All Categories</option>
                            <option value="fiction" {{ request('category') == 'fiction' ? 'selected' : '' }}>Fiction</option>
                            <option value="non-fiction" {{ request('category') == 'non-fiction' ? 'selected' : '' }}>Non-Fiction</option>
                            <option value="mystery" {{ request('category') == 'mystery' ? 'selected' : '' }}>Mystery</option>
                            <option value="romance" {{ request('category') == 'romance' ? 'selected' : '' }}>Romance</option>
                            <option value="science-fiction" {{ request('category') == 'science-fiction' ? 'selected' : '' }}>Science Fiction</option>
                            <option value="fantasy" {{ request('category') == 'fantasy' ? 'selected' : '' }}>Fantasy</option>
                            <option value="biography" {{ request('category') == 'biography' ? 'selected' : '' }}>Biography</option>
                            <option value="history" {{ request('category') == 'history' ? 'selected' : '' }}>History</option>
                            <option value="self-help" {{ request('category') == 'self-help' ? 'selected' : '' }}>Self Help</option>
                            <option value="business" {{ request('category') == 'business' ? 'selected' : '' }}>Business</option>
                            <option value="technology" {{ request('category') == 'technology' ? 'selected' : '' }}>Technology</option>
                            <option value="educational" {{ request('category') == 'educational' ? 'selected' : '' }}>Educational</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Summary -->
        <div class="mb-4">
            <p class="text-secondary">
                @if($books->total() > 0)
                Showing {{ $books->firstItem() }} to {{ $books->lastItem() }} of {{ $books->total() }} books
                @if(request('search') || request('category'))
                @if(request('search') && request('category'))
                matching "{{ request('search') }}" in {{ ucfirst(str_replace('-', ' ', request('category'))) }} category
                @elseif(request('search'))
                matching "{{ request('search') }}"
                @elseif(request('category'))
                in {{ ucfirst(str_replace('-', ' ', request('category'))) }} category
                @endif
                @endif
                @else
                @if(request('search') || request('category'))
                @if(request('search') && request('category'))
                No books found matching "{{ request('search') }}" in {{ ucfirst(str_replace('-', ' ', request('category'))) }} category
                @elseif(request('search'))
                No books found matching "{{ request('search') }}"
                @elseif(request('category'))
                No books found in {{ ucfirst(str_replace('-', ' ', request('category'))) }} category
                @endif
                @else
                No books available for rental at the moment
                @endif
                @endif
            </p>
        </div>

        <div class="row g-3 justify-content-center mb-4">
            <div class="col-auto">
                <a href="{{ route('books.index') }}" class="text-decoration-none">
                    <div class="card text-white bg-primary text-center {{ empty($status) ? 'shadow-lg' : '' }}">
                        <div class="card-body py-2">
                            <i class="fas fa-book fa-lg mb-1"></i>
                            <div class="fw-bold fs-5">{{ $stats['total'] ?? $books->total() }}</div>
                            <div class="small">Total Books</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-auto">
                <a href="{{ route('books.index', ['status' => 'available', 'search' => request('search'), 'category' => request('category')]) }}" class="text-decoration-none">
                    <div class="card text-white bg-success text-center {{ ($status ?? '') === 'available' ? 'shadow-lg' : '' }}">
                        <div class="card-body py-2">
                            <i class="fas fa-check-circle fa-lg mb-1"></i>
                            <div class="fw-bold fs-5">{{ $stats['available'] ?? 0 }}</div>
                            <div class="small">Available</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-auto">
                <a href="{{ route('books.index', ['status' => 'rented', 'search' => request('search'), 'category' => request('category')]) }}" class="text-decoration-none">
                    <div class="card text-white bg-warning text-center {{ ($status ?? '') === 'rented' ? 'shadow-lg' : '' }}">
                        <div class="card-body py-2">
                            <i class="fas fa-handshake fa-lg mb-1"></i>
                            <div class="fw-bold fs-5">{{ $stats['rented'] ?? 0 }}</div>
                            <div class="small">Rented Out</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-auto">
                <a href="{{ route('user.myRentals') }}" class="text-decoration-none">
                    <div class="card text-white bg-info text-center">
                        <div class="card-body py-2">
                            <i class="fas fa-book-reader fa-lg mb-1"></i>
                            <div class="fw-bold fs-6">My Rentals</div>
                            <div class="small">Books I Rented</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        @if($books->count() > 0)
        <div class="row g-4">
            @foreach($books as $book)
            @if($book->lender_id === Auth::id())
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="position-relative">
                        @if($book->image_path)
                        <img src="{{ asset($book->image_path) }}" class="card-img-top" alt="{{ $book->title }}">
                        @else
                        <div class="d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                            <i class="fas fa-book fa-3x text-muted"></i>
                        </div>
                        @endif
                        @php
                            $statusClass = 'bg-secondary';
                            if ($book->status === 'available') $statusClass = 'bg-success';
                            elseif ($book->status === 'rented') $statusClass = 'bg-info';
                        @endphp
                        <span class="badge {{ $statusClass }} position-absolute top-0 end-0 m-2">{{ ucfirst($book->status) }}</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title fw-bold mb-2">{{ $book->title }}</h6>
                        <p class="text-muted small mb-2"><i class="fas fa-user me-1"></i>{{ $book->author }}</p>
                        <p class="text-muted small mb-2"><i class="fas fa-tags me-1"></i>{{ $book->genre }}</p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-success">${{ number_format($book->rental_price_per_day, 2) }}/day</span>
                            <small class="text-muted"><i class="fas fa-star me-1"></i>{{ ucfirst($book->condition) }}</small>
                        </div>
                        <p class="card-text small text-muted flex-grow-1">{{ Str::limit($book->description, 80) }}</p>
                        <div class="mt-auto">
                            <a href="{{ route('books.show', $book) }}" class="btn btn-outline-primary btn-sm w-100">See Details</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
            @if ($books->hasPages())
                {{ $books->onEachSide(1)->links('pagination::bootstrap-5') }}
            @endif
        </div>
        @else
        <div class="text-center py-5 text-light">
            <i class="fas fa-book-open fa-5x mb-4 opacity-75"></i>
            <h4 class="text-white">No Books Yet</h4>
            <p class="mb-4">Start building your book collection and earn money by renting them out!</p>
            <a href="{{ route('admin.books.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i>Add Your First Book
            </a>
        </div>
        @endif
    </div>
    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>