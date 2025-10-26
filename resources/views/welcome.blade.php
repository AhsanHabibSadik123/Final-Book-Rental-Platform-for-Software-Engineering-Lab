<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'BookStore') }} - Your Book Rental Marketplace</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
    body { 
        background: linear-gradient(135deg, #556a7eff 0%, #556a7eff 100%);
        min-height: 100vh;
    }
    html { scroll-behavior: smooth; }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
        }
        .feature-card {
            transition: transform 0.3s ease;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .stats-section {
            background-color: #f8f9fa;
            padding: 60px 0;
        }
        .stat-item {
            text-align: center;
        }
        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            color: #667eea;
        }

    /* How it Works */
    .howit-card { border: none; box-shadow: 0 6px 18px rgba(0,0,0,.06); transition: transform .25s ease, box-shadow .25s ease; border-radius: 1rem; }
    .howit-card:hover { transform: translateY(-4px); box-shadow: 0 10px 24px rgba(0,0,0,.08); }
    .howit-icon { width: 56px; height: 56px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; font-size: 1.25rem; }
    .howit-divider { width: 120px; height: 4px; background: linear-gradient(90deg, #667eea, #764ba2); border-radius: 999px; }

    /* Reveal animation */
    .fade-in-up { opacity: 0; transform: translateY(16px); transition: opacity .6s ease, transform .6s ease; }
    .fade-in-up.show { opacity: 1; transform: none; }

    /* Professional dark gradient navbar */
    .admin-navbar {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        box-shadow: 0 2px 8px rgba(189, 199, 209, 0.08);
    }
    .admin-navbar .navbar-brand { color: #fff !important; font-weight: 700; }
    .admin-navbar .nav-link, .admin-navbar .dropdown-item { color: #fff !important; font-weight: 500; }
    .admin-navbar .dropdown-menu { background: #34495e; }
    .admin-navbar .dropdown-item:hover { background: #667eea; color: #fff !important; }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark admin-navbar shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <i class="fas fa-book me-2"></i>BookStore
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">How It Works</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#stats">Stats</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary ms-2" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i>Join Now
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('books.index') }}">My Books</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">
                        Your Book Rental Marketplace
                    </h1>
                    <p class="lead mb-4">
                        Rent books from fellow readers or earn money by lending your collection. 
                        Join our community of book lovers today!
                    </p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Get Started
                        </a>
                        <a href="#how-it-works" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-play me-2"></i>Learn More
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="fas fa-books display-1" style="font-size: 8rem; opacity: 0.1;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-4">
                <div class="col-lg-8 mx-auto">
                    <h2 class="fw-bold mb-2">How It Works</h2>
                    <p class="text-muted mb-2">Get started in three simple steps</p>
                    <div class="howit-divider mx-auto mt-3"></div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card howit-card h-100 p-4 fade-in-up">
                        <div class="howit-icon bg-primary-subtle text-primary"><i class="fas fa-search"></i></div>
                        <h5 class="fw-semibold mt-3">1) Discover Books</h5>
                        <p class="text-muted mb-0">Browse available titles, filter by genre and price, and view detailed book info.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card howit-card h-100 p-4 fade-in-up">
                        <div class="howit-icon bg-success-subtle text-success"><i class="fas fa-handshake"></i></div>
                        <h5 class="fw-semibold mt-3">2) Rent Securely</h5>
                        <p class="text-muted mb-0">Choose rental days, confirm the booking, and pay a refundable security deposit.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card howit-card h-100 p-4 fade-in-up">
                        <div class="howit-icon bg-info-subtle text-info"><i class="fas fa-book-open"></i></div>
                        <h5 class="fw-semibold mt-3">3) Enjoy & Return</h5>
                        <p class="text-muted mb-0">Pick up or receive your book. Return on time to settle and get your deposit back.</p>
                    </div>
                </div>
            </div>

            <div class="row align-items-center mt-5 g-4">
                <div class="col-md-6">
                    <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm fade-in-up">
                        <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?q=80&w=1200&auto=format&fit=crop" alt="How it works overview" class="w-100 h-100 object-fit-cover">
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class="list-group list-group-flush shadow-sm fade-in-up">
                        <li class="list-group-item"><i class="fas fa-check text-success me-2"></i>Verified users and secure wallet payments</li>
                        <li class="list-group-item"><i class="fas fa-check text-success me-2"></i>Transparent pricing with refundable deposits</li>
                        <li class="list-group-item"><i class="fas fa-check text-success me-2"></i>Track rentals and returns from your dashboard</li>
                        <li class="list-group-item"><i class="fas fa-check text-success me-2"></i>Ratings help you pick trusted lenders and books</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="stats-section">
        <div class="container">
            <div class="row text-center mb-4">
                <div class="col-lg-8 mx-auto">
                    <h2 class="fw-bold mb-2">Platform Stats</h2>
                    <p class="text-muted">Growing community of readers and lenders</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="stat-item fade-in-up">
                        <div class="stat-number counter" data-target="{{ \App\Models\Book::where('status', 'available')->count() }}">0</div>
                        <p class="mb-0">Total Books</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item fade-in-up">
                        <div class="stat-number counter" data-target="{{ \App\Models\User::count() }}">0</div>
                        <p class="mb-0"> Total Members</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item fade-in-up">
                        <div class="stat-number counter" data-target="{{ \App\Models\Rental::max('id') ?? 0 }}">0</div>
                        <p class="mb-0">Total Rentals</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item fade-in-up">
                        <div class="stat-number counter" data-target="{{ \App\Models\Book::count() }}">0</div>
                        <p class="mb-0">Books Listed</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="fw-bold mb-3">Why Choose BookStore?</h2>
                    <p class="text-muted">Connect with book lovers in your community</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="text-center mb-3">
                            <i class="fas fa-book-reader text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="text-center">For Borrowers</h4>
                        <p class="text-muted text-center">
                            Access thousands of books at affordable rates. 
                            Read more, spend less!
                        </p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Browse local collections</li>
                            <li><i class="fas fa-check text-success me-2"></i>Affordable daily rates</li>
                            <li><i class="fas fa-check text-success me-2"></i>Easy return process</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="text-center mb-3">
                            <i class="fas fa-hand-holding-usd text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="text-center">For Lenders</h4>
                        <p class="text-muted text-center">
                            Turn your book collection into a source of income. 
                            Help others while earning!
                        </p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Earn from your books</li>
                            <li><i class="fas fa-check text-success me-2"></i>Set your own rates</li>
                            <li><i class="fas fa-check text-success me-2"></i>Secure transactions</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="text-center mb-3">
                            <i class="fas fa-shield-alt text-info" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="text-center">Safe & Secure</h4>
                        <p class="text-muted text-center">
                            Our platform ensures secure transactions and 
                            protects both lenders and borrowers.
                        </p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Verified users</li>
                            <li><i class="fas fa-check text-success me-2"></i>Security deposits</li>
                            <li><i class="fas fa-check text-success me-2"></i>Rating system</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="fw-bold mb-3">Ready to Start Your Reading Journey?</h2>
            <p class="lead mb-4">Join thousands of book lovers in our community</p>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                <i class="fas fa-rocket me-2"></i>Get Started Today
            </a>
        </div>
    </section>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Reveal on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) entry.target.classList.add('show');
            });
        }, { threshold: 0.12 });
        document.querySelectorAll('.fade-in-up').forEach(el => observer.observe(el));

        // Simple counters
        const animateCounter = (el) => {
            const target = parseInt(el.getAttribute('data-target') || '0', 10);
            const duration = 1200;
            const start = performance.now();
            const step = (t) => {
                const p = Math.min((t - start) / duration, 1);
                el.textContent = Math.floor(p * target).toLocaleString();
                if (p < 1) requestAnimationFrame(step);
            };
            requestAnimationFrame(step);
        };
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });
        document.querySelectorAll('.counter').forEach(el => counterObserver.observe(el));
    </script>
</body>
</html>
