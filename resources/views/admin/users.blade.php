<!-- This page is use for managing users in the system. admin can add , remove , manage wallet -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Management - BookStore Admin</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="fas fa-home me-2"></i>Admin Dashboard
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
        <div class="container-fluid" style="padding-bottom: 50px;">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 fw-bold text-white">
                            <i class="fas fa-users me-2"></i>User Management
                        </h1>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                        </a>
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

                    <!-- Filters and Search -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-filter me-2"></i>Filters & Search
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('admin.users') }}" class="row g-3">
                                <div class="col-md-6">
                                    <label for="search" class="form-label">Search Users</label>
                                    <input type="text" class="form-control" id="search" name="search"
                                        value="{{ $search ?? '' }}" placeholder="Name, email, or phone...">
                                </div>
                                <div class="col-md-4">
                                    <label for="status" class="form-label">Verification Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="all" {{ ($status ?? '') === 'all' ? 'selected' : '' }}>All Status</option>
                                        <option value="verified" {{ ($status ?? '') === 'verified' ? 'selected' : '' }}>Verified</option>
                                        <option value="unverified" {{ ($status ?? '') === 'unverified' ? 'selected' : '' }}>Unverified</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search me-1"></i>Search
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Users Table -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-users me-2"></i>All Users ({{ $users->total() }})
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($users->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Wallet</th>
                                            <th>Status</th>
                                            <th>Joined</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-user-circle text-secondary me-2" style="font-size: 1.5rem;"></i>
                                                    <div>
                                                        <strong>{{ $user->name }}</strong>
                                                        <br><small class="text-muted">ID: {{ $user->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $user->email }}
                                                @if($user->phone)
                                                <br><small class="text-muted">{{ $user->phone }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $user->role === 'user' ? 'primary' : 'warning' }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-success">${{ number_format($user->wallet, 2) }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $user->is_verified ? 'success' : 'warning' }}">
                                                    {{ $user->is_verified ? 'Verified' : 'Pending' }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $user->created_at->format('M d, Y') }}
                                                <br><small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.users.show', $user) }}"
                                                        class="btn btn-sm btn-outline-primary"
                                                        title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-success verify-btn"
                                                        data-user-id="{{ $user->id }}"
                                                        data-user-name="{{ $user->name }}"
                                                        data-current-status="{{ $user->is_verified ? 'verified' : 'unverified' }}"
                                                        title="{{ $user->is_verified ? 'Unverify' : 'Verify' }}">
                                                        <i class="fas fa-{{ $user->is_verified ? 'times' : 'check' }}"></i>
                                                    </button>

                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-info wallet-btn"
                                                        data-user-id="{{ $user->id }}"
                                                        data-user-name="{{ $user->name }}"
                                                        data-current-balance="{{ $user->wallet }}"
                                                        title="Manage Wallet">
                                                        <i class="fas fa-wallet"></i>
                                                    </button>

                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger delete-btn"
                                                        data-user-id="{{ $user->id }}"
                                                        data-user-name="{{ $user->name }}"
                                                        title="Delete User">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $users->appends(['search' => $search, 'status' => $status])->links() }}
                            </div>
                            @else
                            <div class="text-center py-5">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Users Found</h5>
                                <p class="text-muted">
                                    @if($search || $status !== 'all')
                                    No users match your current filters. Try adjusting your search criteria.
                                    @else
                                    No users are registered yet.
                                    @endif
                                </p>
                                @if($search || $status !== 'all')
                                <a href="{{ route('admin.users') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-times me-1"></i>Clear Filters
                                </a>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Verify/Unverify User Modal -->
    <div class="modal fade" id="verifyModal" tabindex="-1" aria-labelledby="verifyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold" id="verifyModalLabel">
                        <i class="fas fa-user-check me-2"></i>Update User Verification
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="fas fa-user-shield fa-4x text-primary"></i>
                        </div>
                        <h4 class="text-primary fw-bold" id="verifyUserName">User Name</h4>
                        <p class="text-muted mb-0" id="verifyAction">Action message here</p>
                    </div>

                    <div class="mb-3">
                        <label for="verifyNotes" class="form-label fw-bold">Admin Notes (Optional)</label>
                        <textarea class="form-control" id="verifyNotes" rows="3"
                            placeholder="Optional notes about this verification change..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-success" id="confirmVerifyBtn">
                        <i class="fas fa-check me-1"></i>Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Wallet Modal -->
    <div class="modal fade" id="walletModal" tabindex="-1" aria-labelledby="walletModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title fw-bold" id="walletModalLabel">
                        <i class="fas fa-wallet me-2"></i>Update User Wallet
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="walletError" class="alert alert-danger d-none" role="alert"></div>
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="fas fa-dollar-sign fa-4x text-info"></i>
                        </div>
                        <h4 class="text-primary fw-bold" id="walletUserName">User Name</h4>
                        <p class="text-muted mb-0">Current balance: <span id="currentBalance" class="fw-bold text-success"></span></p>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="walletAction" class="form-label fw-bold">Action</label>
                            <select class="form-select" id="walletAction" required>
                                <option value="">Select action...</option>
                                <option value="add">Add Money</option>
                                <option value="subtract">Subtract Money</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="walletAmount" class="form-label fw-bold">Amount ($)</label>
                            <input type="number" class="form-control" id="walletAmount"
                                min="0" max="99999.99" step="0.01" placeholder="0.00" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="walletNotes" class="form-label fw-bold">Admin Notes <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="walletNotes" rows="3"
                            placeholder="Reason for wallet adjustment (required)..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-info" id="confirmWalletBtn">
                        <i class="fas fa-dollar-sign me-1"></i>Update Wallet
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Delete User Account
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="fas fa-user-times fa-4x text-danger"></i>
                        </div>
                        <h4 class="text-danger fw-bold" id="deleteUserName">User Name</h4>
                        <p class="text-muted mb-0">Are you sure you want to delete this user account?</p>
                    </div>

                    <div class="alert alert-warning">
                        <h6 class="fw-bold">⚠️ Warning:</h6>
                        <ul class="mb-0">
                            <li>This action <strong>CANNOT</strong> be undone</li>
                            <li>All user data will be permanently removed</li>
                            <li>User must have no active rentals or listed books</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash me-1"></i>Yes, Delete User
                    </button>
                </div>
            </div>
        </div>
    </div>

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

        .table th {
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }

        .btn-group .btn {
            margin-right: 2px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        .modal-content {
            border-radius: 10px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentUserId = null;
            let currentUserName = null;
            let lastWalletRow = null; // track the row whose wallet we're updating
            let lastVerifyRow = null; // track the row whose verify status we're updating
            let lastVerifyBtn = null; // track the verify button clicked

            // Get modal elements
            const verifyModal = new bootstrap.Modal(document.getElementById('verifyModal'));
            const walletModal = new bootstrap.Modal(document.getElementById('walletModal'));
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

            // Event delegation for buttons
            document.addEventListener('click', function(e) {
                // Verify button
                if (e.target.closest('.verify-btn')) {
                    const button = e.target.closest('.verify-btn');
                    currentUserId = button.dataset.userId;
                    currentUserName = button.dataset.userName;
                    const currentStatus = button.dataset.currentStatus;
                    lastVerifyRow = button.closest('tr');
                    lastVerifyBtn = button;

                    document.getElementById('verifyUserName').textContent = currentUserName;
                    // clear any previous notes
                    const verifyNotesEl = document.getElementById('verifyNotes');
                    if (verifyNotesEl) verifyNotesEl.value = '';

                    if (currentStatus === 'verified') {
                        document.getElementById('verifyAction').textContent = 'Are you sure you want to unverify this user?';
                        document.getElementById('confirmVerifyBtn').innerHTML = '<i class="fas fa-times me-1"></i>Unverify';
                        document.getElementById('confirmVerifyBtn').className = 'btn btn-warning';
                    } else {
                        document.getElementById('verifyAction').textContent = 'Are you sure you want to verify this user?';
                        document.getElementById('confirmVerifyBtn').innerHTML = '<i class="fas fa-check me-1"></i>Verify';
                        document.getElementById('confirmVerifyBtn').className = 'btn btn-success';
                    }

                    verifyModal.show();
                }

                // Wallet button
                if (e.target.closest('.wallet-btn')) {
                    const button = e.target.closest('.wallet-btn');
                    currentUserId = button.dataset.userId;
                    currentUserName = button.dataset.userName;
                    const currentBalance = button.dataset.currentBalance;
                    lastWalletRow = button.closest('tr');

                    document.getElementById('walletUserName').textContent = currentUserName;
                    document.getElementById('currentBalance').textContent = '$' + parseFloat(currentBalance).toFixed(2);
                    // Clear previous wallet error alert
                    const walletErrorEl = document.getElementById('walletError');
                    if (walletErrorEl) {
                        walletErrorEl.textContent = '';
                        walletErrorEl.classList.add('d-none');
                    }

                    walletModal.show();
                }

                // Delete button
                if (e.target.closest('.delete-btn')) {
                    const button = e.target.closest('.delete-btn');
                    currentUserId = button.dataset.userId;
                    currentUserName = button.dataset.userName;

                    document.getElementById('deleteUserName').textContent = currentUserName;
                    deleteModal.show();
                }
            });

            // Confirm actions
            document.getElementById('confirmVerifyBtn').addEventListener('click', function() {
                if (currentUserId) {
                    const notes = (document.getElementById('verifyNotes')?.value || '').trim();
                    const currentlyVerified = (lastVerifyBtn?.dataset.currentStatus === 'verified');
                    const desiredIsVerified = !currentlyVerified;
                    updateUserStatus(currentUserId, desiredIsVerified, notes);
                    verifyModal.hide();
                }
            });

            document.getElementById('confirmWalletBtn').addEventListener('click', function() {
                if (currentUserId) {
                    const action = document.getElementById('walletAction').value;
                    const amount = document.getElementById('walletAmount').value;
                    const notes = document.getElementById('walletNotes').value;
                    const currentBalanceText = document.getElementById('currentBalance')?.textContent || '$0.00';
                    const currentBalance = parseFloat(currentBalanceText.replace(/[^0-9.\-]/g, '')) || 0;
                    const walletErrorEl = document.getElementById('walletError');

                    if (!action || !amount || !notes) {
                        alert('Please fill in all required fields.');
                        return;
                    }

                    // Client-side guard: prevent subtracting more than current balance
                    if (action === 'subtract' && parseFloat(amount) > currentBalance) {
                        if (walletErrorEl) {
                            walletErrorEl.textContent = "Cannot subtract more than the user's current balance.";
                            walletErrorEl.classList.remove('d-none');
                        } else {
                            alert("Cannot subtract more than the user's current balance.");
                        }
                        return;
                    }

                    updateUserWallet(currentUserId, action, amount, notes);
                    walletModal.hide();
                }
            });

            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                if (currentUserId) {
                    deleteUser(currentUserId);
                    deleteModal.hide();
                }
            });

            // API functions
            function updateUserStatus(userId, isVerified, notes) {
                fetch(`/admin/users/${userId}/status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            is_verified: !!isVerified,
                            admin_notes: notes || null
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            try {
                                const newStatus = (data.new_status || (isVerified ? 'verified' : 'unverified'));
                                const nowVerified = newStatus === 'verified';
                                // Update status badge (5th column)
                                const badge = lastVerifyRow?.querySelector('td:nth-child(5) span.badge');
                                if (badge) {
                                    badge.textContent = nowVerified ? 'Verified' : 'Pending';
                                    badge.classList.remove('bg-success', 'bg-warning');
                                    badge.classList.add(nowVerified ? 'bg-success' : 'bg-warning');
                                }
                                // Update verify button icon/title/data
                                if (lastVerifyBtn) {
                                    lastVerifyBtn.dataset.currentStatus = nowVerified ? 'verified' : 'unverified';
                                    lastVerifyBtn.title = nowVerified ? 'Unverify' : 'Verify';
                                    const icon = lastVerifyBtn.querySelector('i');
                                    if (icon) {
                                        icon.classList.remove('fa-check', 'fa-times');
                                        icon.classList.add(nowVerified ? 'fa-times' : 'fa-check');
                                    }
                                }
                            } catch (_) { /* no-op */ }
                        } else {
                            alert('Error: ' + (data.message || 'Failed to update status'));
                        }
                    })
                    .catch(() => alert('An error occurred'));
            }

            function updateUserWallet(userId, action, amount, notes) {
                fetch(`/admin/users/${userId}/wallet`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            action,
                            amount: parseFloat(amount),
                            admin_notes: notes
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update wallet balance in the table without reloading
                            try {
                                const walletCellSpan = lastWalletRow?.querySelector('td:nth-child(4) span.fw-bold');
                                if (walletCellSpan) {
                                    walletCellSpan.textContent = '$' + Number(data.new_balance).toFixed(2);
                                }
                                // Update the wallet button's current balance for future opens
                                const walletBtn = lastWalletRow?.querySelector('.wallet-btn');
                                if (walletBtn) {
                                    walletBtn.dataset.currentBalance = Number(data.new_balance).toFixed(2);
                                }
                                // Also update the modal header current balance if present
                                const currentBalanceEl = document.getElementById('currentBalance');
                                if (currentBalanceEl) {
                                    currentBalanceEl.textContent = '$' + Number(data.new_balance).toFixed(2);
                                }
                            } catch (_) { /* no-op */ }
                        } else {
                            alert('Error: ' + (data.message || 'Failed to update wallet'));
                        }
                    })
                    .catch(() => alert('An error occurred'));
            }

            function deleteUser(userId) {
                fetch(`/admin/users/${userId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            try {
                                // Remove the corresponding row
                                const row = document.querySelector(`.delete-btn[data-user-id='${userId}']`)?.closest('tr');
                                if (row) {
                                    row.remove();
                                }
                                // Update the total users count in the card header title
                                const headerTitle = document.querySelector('.card-header .card-title');
                                const match = headerTitle?.textContent?.match(/All Users \((\d+)\)/);
                                if (match && headerTitle) {
                                    const current = parseInt(match[1], 10);
                                    const next = Math.max(0, current - 1);
                                    headerTitle.textContent = headerTitle.textContent.replace(/All Users \(\d+\)/, `All Users (${next})`);
                                }
                            } catch (_) { /* no-op */ }
                        } else {
                            alert('Error: ' + (data.message || 'Failed to delete user'));
                        }
                    })
                    .catch(() => alert('An error occurred'));
            }
        });
    </script>
    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>