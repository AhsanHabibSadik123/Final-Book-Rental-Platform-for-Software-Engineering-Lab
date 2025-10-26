<!-- This page is for viewing book details. -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details - BookStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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
        body {
            background: linear-gradient(135deg, #556a7eff 0%, #556a7eff 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .book-details-simple {
            background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(44, 62, 80, 0.10);
            padding: 2.5rem 2rem;
            max-width: 480px;
            margin: 48px auto;
            transition: box-shadow 0.3s;
        }

        .book-details-simple:hover {
            box-shadow: 0 8px 32px rgba(44, 62, 80, 0.15);
        }

        .book-image {
            width: 100%;
            max-width: 200px;
            height: 260px;
            object-fit: cover;
            border-radius: 12px;
            background: #f8f9fa;
            margin-bottom: 1.2rem;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.07);
        }

        .badge {
            font-size: 1rem;
            padding: 0.35rem 1rem;
            border-radius: 12px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        h2.fw-bold {
            font-size: 2rem;
            color: #34495e;
        }

        p.mb-1,
        p.mb-3 {
            color: #495057;
            font-size: 1.05rem;
        }

        strong {
            color: #667eea;
        }
    </style>
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
    <main>
        <div class="container mt-4 text-end">
            <a href="{{ route('books.browse') }}" class="btn btn-primary mb-3">
                <i class="fas fa-arrow-left me-2"></i>Browse Books
            </a>
        </div>
        <div class="book-details-simple text-center">

            @if($book->image_path)
            <img src="{{ asset($book->image_path) }}" alt="{{ $book->title }}" class="book-image">
            @else
            <div class="book-image d-flex align-items-center justify-content-center bg-light">
                <i class="fas fa-book fa-3x text-muted"></i>
            </div>
            @endif
            <h2 class="fw-bold mb-2">{{ $book->title }}</h2>
            <p class="mb-1"><strong>Author:</strong> {{ $book->author }}</p>
            <p class="mb-1"><strong>Genre:</strong> {{ $book->genre }}</p>
            <p class="mb-1"><strong>Condition:</strong> {{ ucfirst($book->condition) }}</p>
            <p class="mb-1"><strong>Status:</strong> <span class="badge bg-primary">{{ ucfirst($book->status) }}</span></p>
            <p class="mb-1"><strong>Rental Price/Day:</strong> ${{ number_format($book->rental_price_per_day, 2) }}</p>
            <p class="mb-1"><strong>Security Deposit:</strong> ${{ number_format($book->security_deposit, 2) }}</p>
            <p class="mb-1"><strong>ISBN:</strong> {{ $book->isbn }}</p>
            <p class="mb-3"><strong>Description:</strong> {{ $book->description }}</p>
        </div>
    </main>
    @include('layouts.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>