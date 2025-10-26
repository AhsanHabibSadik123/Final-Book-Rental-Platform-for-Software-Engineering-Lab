<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Details - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #556a7e 0%, #556a7e 100%); min-height: 100vh; }
        .admin-navbar { background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); }
        .card { border: none; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,.2); }
    </style>
    </head>

<body>
    <nav class="navbar navbar-expand-lg admin-navbar navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-shield-alt me-2"></i>Admin Panel
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
                            <li><a class="dropdown-item" href="{{ route('admin.users') }}"><i class="fas fa-users me-2"></i>User Management</a></li>
                            <li><hr class="dropdown-divider"></li>
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white mb-0"><i class="fas fa-user me-2"></i>User Details</h2>
            <a href="{{ route('admin.users') }}" class="btn btn-primary"><i class="fas fa-arrow-left me-1"></i> Back to Users</a>
        </div>

        <div class="row g-3">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <strong><i class="fas fa-id-card me-2"></i>Profile</strong>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-user-circle fa-3x text-secondary me-3"></i>
                            <div>
                                <div class="fw-bold">{{ $user->name }}</div>
                                <div class="text-muted">ID: {{ $user->id }}</div>
                            </div>
                        </div>
                        <div class="mb-2"><i class="fas fa-envelope me-2 text-muted"></i>{{ $user->email }}</div>
                        @if($user->phone)
                            <div class="mb-2"><i class="fas fa-phone me-2 text-muted"></i>{{ $user->phone }}</div>
                        @endif
                        @if($user->address)
                            <div class="mb-2"><i class="fas fa-location-dot me-2 text-muted"></i>{{ $user->address }}</div>
                        @endif
                        <div class="mb-2">
                            <span class="badge bg-{{ $user->is_verified ? 'success' : 'warning' }}">
                                {{ $user->is_verified ? 'Verified' : 'Pending' }}
                            </span>
                            <span class="badge bg-info ms-1">{{ ucfirst($user->role) }}</span>
                        </div>
                        <div class="mb-2">
                            <strong>Wallet:</strong> <span class="text-success">${{ number_format($user->wallet, 2) }}</span>
                        </div>
                        <div class="text-muted">Joined: {{ $user->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-header bg-secondary text-white">
                        <strong><i class="fas fa-book me-2"></i>Recent Books Listed</strong>
                    </div>
                    <div class="card-body">
                        @if($recentBooks->count())
                            <div class="table-responsive">
                                <table class="table table-sm align-middle">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Status</th>
                                            <th>Added</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentBooks as $book)
                                            <tr>
                                                <td>{{ $book->title }}</td>
                                                <td>{{ $book->author }}</td>
                                                <td>
                                                    @if($book->status === 'available')
                                                        <span class="badge bg-success">Available</span>
                                                    @elseif($book->status === 'rented')
                                                        <span class="badge bg-info">Rented</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ ucfirst($book->status) }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $book->created_at->format('M d, Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center text-muted">No recent books.</div>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <strong><i class="fas fa-handshake me-2"></i>Recent Rentals (as Borrower)</strong>
                    </div>
                    <div class="card-body">
                        @if($recentRentals->count())
                            <div class="table-responsive">
                                <table class="table table-sm align-middle">
                                    <thead>
                                        <tr>
                                            <th>Book</th>
                                            <th>Lender</th>
                                            <th>Period</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentRentals as $r)
                                            <tr>
                                                <td>{{ $r->book->title ?? '-' }}</td>
                                                <td>{{ optional($r->book->lender)->name ?? '-' }}</td>
                                                <td>{{ optional($r->rental_start_date)->format('M d, Y') }} - {{ optional($r->rental_end_date)->format('M d, Y') }}</td>
                                                <td><span class="badge bg-secondary">{{ ucfirst($r->status) }}</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center text-muted">No recent rentals.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
