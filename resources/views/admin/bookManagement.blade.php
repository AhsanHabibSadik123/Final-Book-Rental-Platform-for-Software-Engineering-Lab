<!-- this page is use in admin Book Management -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Book Management - BookStore</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        /* Global Styles */
        body {
            background: linear-gradient(135deg, #556a7eff 0%, #556a7eff 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #212529;
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

        /* Main Content */
        .admin-content {
            margin-top: 0;
            padding-top: 20px;
        }

        .card-body {
            background: #fff;
            color: #212529;
            padding: 20px;
        }

        .nav-tabs .nav-link.active {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
            color: #ffffff !important;
            border: none;
        }

        /* Table Styles */


        .table thead th {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: #ffffff !important;
            font-weight: 600;
            border: none;
            padding: 15px 12px;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #e9ecef;
            background: #fff;
        }

        .table tbody tr:hover {
            background: #f8f9fa !important;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .table tbody td {
            padding: 15px 12px;
            vertical-align: middle;
            border: none;
            color: #212529;
            background: inherit;
        }

        .table tbody td strong {
            color: #212529 !important;
            font-weight: 600;
        }

        .table tbody td .text-muted {
            color: #6c757d !important;
        }



        /* Images */
        .img-thumbnail {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .img-thumbnail:hover {
            transform: scale(1.1);
            border-color: #007bff;
        }
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="text-white fw-bold">Book Management</h2>
                        <div class="d-flex gap-2 align-items-center">
                            <form method="GET" action="{{ route('admin.books') }}" class="d-flex me-2" role="search">
                                <input type="hidden" name="status" value="{{ $status }}" />
                                <input
                                    class="form-control form-control-sm me-2"
                                    type="search"
                                    name="search"
                                    value="{{ $search ?? '' }}"
                                    placeholder="Search books..."
                                    aria-label="Search"
                                />
                                <button class="btn btn-sm btn-outline-light" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                            <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Add New Book
                            </a>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                            </a>
                        </div>
                    </div>

                    {{-- Search Books --}}

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
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- Filter Tabs -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link rounded-pill px-4 py-2 {{ $status === 'all' ? 'active' : '' }}"
                                        href="{{ route('admin.books', ['status' => 'all']) }}">
                                        All Books
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link rounded-pill px-4 py-2 {{ $status === 'available' ? 'active' : '' }}"
                                        href="{{ route('admin.books', ['status' => 'available']) }}">
                                        Available
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link rounded-pill px-4 py-2 {{ $status === 'rented' ? 'active' : '' }}"
                                        href="{{ route('admin.books', ['status' => 'rented']) }}">
                                        Rented
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>

                    <!-- Books Table -->
                    <div class="card">
                        <div class="card-body">
                            @if($books->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Book Details</th>
                                            <th>Owner Info</th>
                                            <th>Borrower</th>
                                            <th>Pricing</th>
                                            <th>Status</th>
                                            <th>Added Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($books as $book)
                                        <tr>
                                            <td>
                                                @if($book->image_path)
                                                <img src="{{ asset($book->image_path) }}"
                                                    alt="{{ $book->title }}"
                                                    class="img-thumbnail"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                <div class="bg-light d-flex align-items-center justify-content-center"
                                                    style="width: 50px; height: 50px;">
                                                    <i class="fas fa-book text-muted"></i>
                                                </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $book->title }}</strong><br>
                                                    <small class="text-muted">by {{ $book->author }}</small><br>
                                                    <small class="text-muted">Genre: {{ $book->genre }}</small><br>
                                                    <small class="text-muted">Condition: {{ ucfirst(str_replace('_', ' ', $book->condition)) }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    @if($book->lender_id)
                                                    <strong>{{ $book->lender->name }}</strong><br>
                                                    <small class="text-muted">{{ $book->lender->email }}</small><br>
                                                    <small class="text-muted">{{ $book->lender->phone }}</small>
                                                    @else
                                                    <small class="text-muted">Admin Added</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if($book->status === 'rented' && optional($book->currentRental)->borrower)
                                                    <div>
                                                        <strong>{{ $book->currentRental->borrower->name }}</strong><br>
                                                        <small class="text-muted">{{ $book->currentRental->borrower->email }}</small>
                                                    </div>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>${{ number_format($book->rental_price_per_day, 2) }}/day</strong><br>
                                                    <small class="text-muted">Deposit: ${{ number_format($book->security_deposit, 2) }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                @if($book->status === 'available')
                                                <span class="badge bg-success">Available</span>
                                                @elseif($book->status === 'rented')
                                                <span class="badge bg-info">Rented</span>
                                                @else
                                                <span class="badge bg-secondary">{{ ucfirst($book->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $book->created_at->format('M d, Y') }}<br>
                                                <small class="text-muted">{{ $book->created_at->format('h:i A') }}</small>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column gap-1">
                                                    <a href="{{ route('admin.books.show', ['book' => $book->id]) }}"
                                                        class="btn btn-sm btn-outline-primary w-100">
                                                        <i class="fas fa-eye me-1"></i> View
                                                    </a>

                                                    <a href="{{ route('admin.books.edit', $book) }}"
                                                        class="btn btn-sm btn-warning w-100">
                                                        <i class="fas fa-edit me-1"></i> Edit
                                                    </a>

                                                    @if($book->status === 'rented')
                                                    <button type="button"
                                                        class="btn btn-sm btn-success w-100 return-btn"
                                                        data-book-id="{{ $book->id }}"
                                                        data-book-title="{{ $book->title }}"
                                                        data-action="{{ route('admin.books.return', $book) }}">
                                                        <i class="fas fa-undo me-1"></i> Return
                                                    </button>
                                                    @endif

                                                    @if($book->status === 'available')
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger w-100 delete-btn"
                                                        data-book-id="{{ $book->id }}"
                                                        data-book-title="{{ $book->title }}">
                                                        <i class="fas fa-trash me-1"></i> Delete
                                                    </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if ($books->hasPages())
                            <nav class="mt-4" aria-label="Books pagination">
                                <ul class="pagination justify-content-center">
                                    {{-- Previous Page Link --}}
                                    @if ($books->onFirstPage())
                                        <li class="page-item disabled" aria-disabled="true" aria-label="Previous">
                                            <span class="page-link" aria-hidden="true">&laquo;</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $books->appends(['status' => $status, 'search' => $search])->previousPageUrl() }}" rel="prev" aria-label="Previous">&laquo;</a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @for ($page = 1; $page <= $books->lastPage(); $page++)
                                        @php $url = $books->appends(['status' => $status, 'search' => $search])->url($page); @endphp
                                        @if ($page == $books->currentPage())
                                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                        @else
                                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endfor

                                    {{-- Next Page Link --}}
                                    @if ($books->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $books->appends(['status' => $status, 'search' => $search])->nextPageUrl() }}" rel="next" aria-label="Next">&raquo;</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled" aria-disabled="true" aria-label="Next">
                                            <span class="page-link" aria-hidden="true">&raquo;</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                            @endif
                            @else
                            <div class="text-center py-5">
                                <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No books found</h5>
                                <p class="text-muted">
                                    @if($status === 'available')
                                    No books are currently available for rent.
                                    @elseif($status === 'rented')
                                    No books are currently rented out.
                                    @else
                                    No books have been added to the system yet.
                                    @endif
                                </p>
                                <a href="{{ route('admin.books.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus me-2"></i>Add First Book
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <!-- Return Book Modal -->
            <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <form id="returnForm" method="POST" class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title fw-bold" id="returnModalLabel">
                                <i class="fas fa-undo me-2"></i>Confirm Return
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <p class="mb-2">Are you sure you want to return <strong id="returnBookTitle">this book</strong>?</p>
                                <ul class="text-muted small mb-0">
                                    <li>The borrower will be refunded the security deposit.</li>
                                    <li>The rental will be closed and the book set to Available.</li>
                                </ul>
                            </div>
                            <div class="alert alert-info d-flex align-items-center" role="alert">
                                <i class="fas fa-info-circle me-2"></i>
                                <div>Proceed only if the book has been received in good condition.</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i>Cancel
                            </button>
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-1"></i>Confirm Return
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        <!-- Delete Book Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title fw-bold" id="deleteModalLabel">
                            <i class="fas fa-trash me-2"></i>Delete Book
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="fas fa-exclamation-triangle fa-4x text-danger"></i>
                            </div>
                            <h4 class="text-danger fw-bold" id="deleteBookTitle">Book Title</h4>
                            <p class="text-muted mb-0">Are you sure you want to delete this book?</p>
                        </div>

                        <div class="alert alert-warning">
                            <h6 class="fw-bold">⚠️ Warning:</h6>
                            <ul class="mb-0">
                                <li>This action <strong>CANNOT</strong> be undone</li>
                                <li>The book will be permanently removed</li>
                                <li>Any rental history will be preserved</li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancel
                        </button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                            <i class="fas fa-trash me-1"></i>Delete Book
                        </button>
                    </div>
                </div>
            </div>
        </div>



        <script>
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Book Management page loaded, setting up event listeners...');

                let currentBookId = null;
                let currentBookTitle = null;
                let currentButton = null;
                let currentReturnAction = null;

                // Get modal elements
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                const returnModal = new bootstrap.Modal(document.getElementById('returnModal'));

                // Event delegation for delete buttons
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.delete-btn')) {
                        const button = e.target.closest('.delete-btn');
                        currentBookId = button.getAttribute('data-book-id');
                        currentBookTitle = button.getAttribute('data-book-title');
                        currentButton = button;

                        console.log('Delete button clicked:', currentBookId, currentBookTitle);

                        // Update modal content
                        document.getElementById('deleteBookTitle').textContent = currentBookTitle;

                        // Show modal
                        deleteModal.show();
                    }

                    if (e.target.closest('.return-btn')) {
                        const button = e.target.closest('.return-btn');
                        currentBookId = button.getAttribute('data-book-id');
                        currentBookTitle = button.getAttribute('data-book-title');
                        currentReturnAction = button.getAttribute('data-action');

                        // Update modal content
                        document.getElementById('returnBookTitle').textContent = currentBookTitle || 'this book';
                        const returnForm = document.getElementById('returnForm');
                        if (returnForm && currentReturnAction) {
                            returnForm.setAttribute('action', currentReturnAction);
                        }

                        // Show modal
                        returnModal.show();
                    }
                });

                // Handle delete confirmation
                document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                    if (!currentBookId || !currentButton) return;

                    console.log('User confirmed deletion, processing...');

                    // Store original button state
                    const originalHTML = currentButton.innerHTML;

                    // Add loading state to button
                    currentButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Deleting...';
                    currentButton.disabled = true;
                    currentButton.classList.add('btn-secondary');
                    currentButton.classList.remove('btn-danger');

                    // Hide modal
                    deleteModal.hide();

                    // Get CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    if (!csrfToken) {
                        alert('Error: CSRF token not found. Please refresh the page and try again.');
                        // Reset button on error
                        currentButton.innerHTML = originalHTML;
                        currentButton.disabled = false;
                        currentButton.classList.remove('btn-secondary');
                        currentButton.classList.add('btn-danger');
                        return;
                    }

                    // Make AJAX request
                    fetch(`/admin/books/${currentBookId}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                showSuccessAlert(data.message);

                                // Remove the table row with animation
                                const tableRow = currentButton.closest('tr');
                                if (tableRow) {
                                    tableRow.style.transition = 'all 0.5s ease';
                                    tableRow.style.backgroundColor = '#f8d7da';
                                    tableRow.style.transform = 'scale(0.95)';
                                    tableRow.style.opacity = '0.7';

                                    setTimeout(() => {
                                        tableRow.style.height = '0px';
                                        tableRow.style.padding = '0px';
                                        tableRow.style.margin = '0px';
                                        tableRow.style.overflow = 'hidden';

                                        setTimeout(() => {
                                            tableRow.remove();

                                            // Check if table is empty and show empty state
                                            const tbody = document.querySelector('.table tbody');
                                            if (tbody && tbody.children.length === 0) {
                                                location.reload(); // Reload to show empty state
                                            }
                                        }, 500);
                                    }, 1000);
                                }

                                console.log('Book deleted successfully');
                            } else {
                                // Show error message
                                showErrorAlert(data.message || 'Failed to delete book.');

                                // Reset button on error
                                currentButton.innerHTML = originalHTML;
                                currentButton.disabled = false;
                                currentButton.classList.remove('btn-secondary');
                                currentButton.classList.add('btn-danger');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showErrorAlert('An error occurred while deleting the book.');

                            // Reset button on error
                            currentButton.innerHTML = originalHTML;
                            currentButton.disabled = false;
                            currentButton.classList.remove('btn-secondary');
                            currentButton.classList.add('btn-danger');
                        });
                });

                // Helper function to show success alerts
                function showSuccessAlert(message) {
                    // Remove existing alerts
                    const existingAlerts = document.querySelectorAll('.alert-success');
                    existingAlerts.forEach(alert => alert.remove());

                    // Create new alert
                    const alertHtml = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

                    // Insert at top of container
                    const container = document.querySelector('.container-fluid .row .col-md-12');
                    if (container) {
                        const firstCard = container.querySelector('.card');
                        if (firstCard) {
                            firstCard.insertAdjacentHTML('beforebegin', alertHtml);
                        }
                    }

                    // Auto-dismiss after 5 seconds
                    setTimeout(() => {
                        const newAlert = document.querySelector('.alert-success');
                        if (newAlert) {
                            newAlert.remove();
                        }
                    }, 5000);
                }

                // Helper function to show error alerts
                function showErrorAlert(message) {
                    // Remove existing alerts
                    const existingAlerts = document.querySelectorAll('.alert-danger');
                    existingAlerts.forEach(alert => alert.remove());

                    // Create new alert
                    const alertHtml = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

                    // Insert at top of container
                    const container = document.querySelector('.container-fluid .row .col-md-12');
                    if (container) {
                        const firstCard = container.querySelector('.card');
                        if (firstCard) {
                            firstCard.insertAdjacentHTML('beforebegin', alertHtml);
                        }
                    }

                    // Auto-dismiss after 5 seconds
                    setTimeout(() => {
                        const newAlert = document.querySelector('.alert-danger');
                        if (newAlert) {
                            newAlert.remove();
                        }
                    }, 5000);
                }

                console.log('Book Management event listeners set up successfully');
            });
        </script>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Initialize Bootstrap components
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips and dropdowns
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    @include('layouts.footer')
</body>

</html>