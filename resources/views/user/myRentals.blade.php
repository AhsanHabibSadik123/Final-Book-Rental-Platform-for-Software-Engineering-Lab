<!-- This page lists books the user has rented as a borrower. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Rentals - {{ config('app.name', 'BookStore') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .rent-card {
            background: #fff;
        }

        .badge-status {
            border-radius: 12px;
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
                <ul class="navbar-nav ms-auto">
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

                            <li><a class="dropdown-item" href="{{ route('books.index') }}"><i class="fas fa-book me-2"></i>My Books</a></li>
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

    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="fw-bold text-white mb-1"><i class="fas fa-book-reader me-2"></i>My Rentals</h1>
                <p class="lead text-light">Books you've rented</p>
            </div>
        </div>

        @if($rentals->count() > 0)
        <div class="table-responsive bg-white rounded p-3 shadow-sm">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Book</th>
                        <th>Lender</th>
                        <th>Period</th>
                        <th>Daily Rate</th>
                        <th>Deposit</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rentals as $r)
                    <tr class="rent-card">
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded overflow-hidden" style="width:56px;height:56px;background:#f8f9fa;">
                                    @if($r->book && $r->book->image_path)
                                    <img src="{{ asset($r->book->image_path) }}" alt="{{ $r->book->title }}" class="w-100 h-100" style="object-fit:cover;">
                                    @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted"><i class="fas fa-book"></i></div>
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $r->book->title ?? 'Unknown' }}</div>
                                    <div class="text-muted small">{{ $r->book->author ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="small">
                                <div class="fw-semibold">{{ $r->book->lender->name ?? '—' }}</div>
                                <div class="text-muted">{{ $r->book->lender->email ?? '' }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="small">
                                {{ optional($r->rental_start_date)->format('M d, Y') }} → {{ optional($r->rental_end_date)->format('M d, Y') }}
                            </div>
                        </td>
                        <td>$ {{ number_format($r->daily_rate, 2) }}</td>
                        <td>$ {{ number_format($r->security_deposit, 2) }}</td>
                        <td>
                            @if($r->status === 'active')
                            <span class="badge bg-info badge-status">Active</span>
                            @elseif($r->status === 'completed')
                            <span class="badge bg-success badge-status">Completed</span>
                            @elseif($r->status === 'overdue')
                            <span class="badge bg-warning text-dark badge-status">Overdue</span>
                            @else
                            <span class="badge bg-secondary badge-status">{{ ucfirst($r->status) }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $rentals->links() }}
        </div>
        @else
        <div class="text-center py-5 text-light">
            <i class="fas fa-book-open fa-5x mb-4 opacity-75"></i>
            <h4 class="text-white">No Rentals Yet</h4>
            <p class="mb-4">Browse available books and rent your first one today.</p>
            <a href="{{ route('books.browse') }}" class="btn btn-light btn-lg"><i class="fas fa-search me-2"></i>Browse Books</a>
        </div>
        @endif
    </div>
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>