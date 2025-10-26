<style>
    /* Deep, professional footer background (not pure black/white) */
    .footer-gradient {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    }
    .footer-gradient .link-light:hover { text-decoration: underline; }
</style>
<footer class="footer-gradient text-light pt-5 pb-4 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <a class="navbar-brand d-inline-flex align-items-center mb-2 text-decoration-none text-light" href="{{ route('dashboard') }}">
                    <i class="fas fa-book me-2"></i>
                    <span class="fw-bold">BookStore</span>
                </a>
                <p class="text-white-50 mb-3">Your trusted marketplace to rent and lend books in your community.</p>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <h6 class="text-uppercase fw-semibold mb-3">Explore</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('books.index') }}" class="link-light text-decoration-none">Browse Books</a></li>
                    <li class="mb-2"><a href="{{ route('dashboard') }}" class="link-light text-decoration-none">Dashboard</a></li>
                    <li class="mb-2"><a href="{{ route('login') }}" class="link-light text-decoration-none">Login</a></li>
                    <li class="mb-2"><a href="{{ route('register') }}" class="link-light text-decoration-none">Register</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3">
                <h6 class="text-uppercase fw-semibold mb-3">Company</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="/" class="link-light text-decoration-none">Home</a></li>
                    <li class="mb-2"><a href="#features" class="link-light text-decoration-none">Features</a></li>
                    <li class="mb-2"><a href="#how-it-works" class="link-light text-decoration-none">How it Works</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="text-uppercase fw-semibold mb-3">Contact</h6>
                <ul class="list-unstyled small mb-3">
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-envelope me-2"></i> support@bookstore.com</li>
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-map-marker-alt me-2"></i> Rajshahi City, Bangladesh</li>
                </ul>
            </div>
        </div>
        <hr class="border-light my-4" style="opacity: .25;">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <div class="small text-white-50">&copy; {{ date('Y') }} {{ config('app.name', 'BookStore') }}. All rights reserved.</div>
            <div class="small text-white-50">Built for readers and lenders <i class="fas fa-heart text-danger"></i></div>
        </div>
    </div>
</footer>
