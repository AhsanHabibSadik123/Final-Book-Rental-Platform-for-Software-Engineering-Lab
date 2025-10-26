<!-- This is for see all the available books for the user. -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Browse Books - BookStore</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

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
                <ul class="navbar-nav me-auto"></ul>
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
                            <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user-edit me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('books.index') }}"><i class="fas fa-book me-2"></i>View My Books</a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-home me-2"></i>User Dashboard</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container py-5">
        <h1 class="mb-4 text-center text-white">Browse Available Books</h1>
        <!-- Search and Filters -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('books.browse') }}" method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-6">
                            <label for="search" class="form-label">Search Books</label>
                            <input type="text" name="search" id="search" value="{{ $search }}" class="form-control" placeholder="Search by title, author, genre...">
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
        </div>

        <!-- Results Summary -->
        <div class="mb-4">
            <p class="text-white mb-0">
                @if($books->total() > 0)
                Showing {{ $books->firstItem() }} to {{ $books->lastItem() }} of {{ $books->total() }} books
                @if($search || request('category'))
                @if($search && request('category'))
                matching "{{ $search }}" in {{ ucfirst(str_replace('-', ' ', request('category'))) }} category
                @elseif($search)
                matching "{{ $search }}"
                @elseif(request('category'))
                in {{ ucfirst(str_replace('-', ' ', request('category'))) }} category
                @endif
                @endif
                @else
                @if($search || request('category'))
                @if($search && request('category'))
                No books found matching "{{ $search }}" in {{ ucfirst(str_replace('-', ' ', request('category'))) }} category
                @elseif($search)
                No books found matching "{{ $search }}"
                @elseif(request('category'))
                No books found in {{ ucfirst(str_replace('-', ' ', request('category'))) }} category
                @endif
                @else
                No books available for rental at the moment
                @endif
                @endif
            </p>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @forelse($books as $book)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm">
                    @php
                    $img = $book->image_path ? asset($book->image_path) : 'https://via.placeholder.com/600x400?text=No+Image';
                    @endphp
                    <img src="{{ $img }}" class="card-img-top img-fluid" alt="{{ $book->title }}"
                        loading="lazy"
                        onerror="this.onerror=null;this.src='https://via.placeholder.com/600x400?text=No+Image';">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-truncate mb-1">{{ $book->title }}</h5>
                        <div class="small text-muted mb-1">by {{ $book->author }}</div>
                        <div class="badge bg-light text-dark align-self-start mb-2">{{ ucfirst($book->genre) }}</div>
                        <div class="small mb-2">Condition: {{ ucfirst($book->condition) }}</div>
                        <div class="fw-semibold text-success mb-3">${{ number_format($book->rental_price_per_day, 2) }}/day</div>
                        <div class="mt-auto d-grid gap-2">
                            <a href="{{ route('books.show', $book) }}" class="btn btn-outline-primary">View Details</a>
                            <a href="{{ route('books.rent', $book) }}"
                                class="btn btn-primary rent-btn"
                                data-lender-id="{{ $book->lender_id }}"
                                data-borrower-id="{{ Auth::id() }}"
                                data-book-title="{{ $book->title }}">
                                Rent Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center py-5 mb-0">
                    <i class="fas fa-search fa-2x mb-3"></i>
                    <h4 class="mb-0">No books available for rental at the moment.</h4>
                </div>
            </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center mt-4">
            @if ($books->hasPages())
            {{ $books->onEachSide(1)->links('pagination::bootstrap-5') }}
            @endif
        </div>

        <!-- Own-book warning modal -->
        <div class="modal fade" id="ownBookModal" tabindex="-1" aria-labelledby="ownBookModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="ownBookModalLabel"><i class="fa-solid fa-circle-exclamation me-2"></i>Action not allowed</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        You cannot borrow your own book.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

    </main>
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Intercept "Rent Now" clicks to prevent renting own book
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.rent-btn');
            if (!btn) return;

            const lenderId = String(btn.dataset.lenderId || '');
            const borrowerId = String(btn.dataset.borrowerId || '');

            if (lenderId && borrowerId && lenderId === borrowerId) {
                e.preventDefault();
                const modalEl = document.getElementById('ownBookModal');
                if (modalEl) {
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.show();
                }
            }
        }, false);
    </script>
    <style>
        /* Keep only the navbar styling as requested */
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

        /* Restore previous background color */
        body {
            background: linear-gradient(135deg, #556a7e 0%, #556a7e 100%);
            min-height: 100vh;
        }
    </style>
</body>


</html>