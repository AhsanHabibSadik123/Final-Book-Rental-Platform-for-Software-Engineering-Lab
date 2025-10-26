<!-- This page is for user dashboard. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - BookStore</title>

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

        /* Navbar Styling */
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
        .navbar-nav .nav-link, .navbar-nav .dropdown-item {
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

        /* Card Styling */
        .card {
            border: none;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
            color: #495057;
        }

        /* Stats Cards */
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stats-card h3 {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0;
        }

        .stats-card h5 {
            opacity: 0.9;
            font-weight: 500;
        }

        /* Button Styling */
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-info {
            background: linear-gradient(135deg, #17a2b8, #138496);
            border: none;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #5a6268);
            border: none;
            border-radius: 8px;
            font-weight: 500;
        }

        /* Book Cards */
        .book-card {
            height: 100%;
            transition: transform 0.2s;
        }

        .book-card:hover {
            transform: translateY(-3px);
        }

        .book-card h6 {
            color: #495057;
            font-weight: 600;
        }

        .book-card .text-muted {
            font-size: 0.875rem;
        }

        .book-card strong {
            color: #28a745;
            font-size: 1.1rem;
        }

        /* Welcome Section */
        .welcome-card {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .welcome-card h1 {
            color: #495057;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        /* Quick Actions */
        .quick-actions .card-body {
            padding: 1.5rem;
        }

        .quick-actions h5 {
            color: #495057;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        /* Search Form */
        .search-form {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .search-form .form-control,
        .search-form .form-select {
            border: 2px solid #dee2e6;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .search-form .form-control:focus,
        .search-form .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            transform: translateY(-1px);
        }

        .search-form .form-select {
            background-color: white;
            cursor: pointer;
        }

        .search-form .btn-primary {
            padding: 12px 24px;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stats-card h3 {
                font-size: 2rem;
            }

            .card-body {
                padding: 1rem;
            }

            .search-form .form-control {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
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

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            <!-- Welcome Message -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card welcome-card">
                        <div class="card-body text-center">
                            <h1>Welcome, {{ Auth::user()->name }}!</h1>
                            <p class="lead text-muted">Discover and rent amazing books from our collection</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- View All Available Books Button -->
            <div class="mt-3 d-flex justify-content-center" style="background: linear-gradient(90deg, #e3e6f0 0%, #f8f9fa 100%); border-radius: 10px; padding: 32px 0; box-shadow: 0 2px 8px rgba(102,126,234,0.08);">
                <a href="{{ route('books.browse') }}" class="btn btn-outline-primary px-4 py-2 fw-bold" style="font-size: 1.1rem; border-radius: 25px;">
                    <i class="fas fa-book-open me-2"></i>View All Available Books
                </a>
            </div>
        </div>
    </main>
    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>