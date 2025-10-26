<!-- this page is for displaying the details of a specific book. admin can view book information here -->
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 fw-bold text-white">
                    <i class="fas fa-book-open me-2"></i>Book Details
                </h1>
                <div class="d-flex gap-2">
                    <span class="badge bg-warning text-dark align-self-center me-2">
                        <i class="fas fa-wallet me-1"></i> Balance: ${{ number_format(Auth::user()->wallet ?? 0, 2) }}
                    </span>
                    <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i> Edit Book
                    </a>
                    <a href="{{ route('admin.books') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Books
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Book Information -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle me-2"></i>Book Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold" style="width: 150px;">
                                                    <i class="fas fa-heading me-2 text-primary"></i>Title:
                                                </td>
                                                <td>{{ $book->title }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">
                                                    <i class="fas fa-user-edit me-2 text-primary"></i>Author:
                                                </td>
                                                <td>{{ $book->author }}</td>
                                            </tr>
                                            @if($book->isbn)
                                            <tr>
                                                <td class="fw-bold">
                                                    <i class="fas fa-barcode me-2 text-primary"></i>ISBN:
                                                </td>
                                                <td>{{ $book->isbn }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td class="fw-bold">
                                                    <i class="fas fa-tags me-2 text-primary"></i>Genre:
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $book->genre }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">
                                                    <i class="fas fa-star me-2 text-primary"></i>Condition:
                                                </td>
                                                <td>
                                                    <span class="badge 
                                                        @if($book->condition === 'excellent') bg-success
                                                        @elseif($book->condition === 'very_good') bg-primary
                                                        @elseif($book->condition === 'good') bg-info
                                                        @elseif($book->condition === 'fair') bg-warning
                                                        @else bg-danger @endif">
                                                        {{ ucfirst(str_replace('_', ' ', $book->condition)) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">
                                                    <i class="fas fa-circle-check me-2 text-primary"></i>Status:
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
                                            </tr>
                                            @if($book->description)
                                            <tr>
                                                <td class="fw-bold align-top">
                                                    <i class="fas fa-align-left me-2 text-primary"></i>Description:
                                                </td>
                                                <td>{{ $book->description }}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Book Image & Additional Info -->
                <div class="col-md-4">
                    <!-- Book Cover -->
                    <div class="card mb-3">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-image me-2"></i>Book Cover
                            </h6>
                        </div>
                        <div class="card-body text-center">
                            @if($book->image_path)
                                    <img src="{{ asset($book->image_path) }}" 
                                     alt="{{ $book->title }}" 
                                     class="img-fluid rounded shadow"
                                     style="max-height: 300px;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                     style="height: 200px;">
                                    <div class="text-center">
                                        <i class="fas fa-book fa-4x text-muted mb-2"></i>
                                        <p class="text-muted">No image available</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Pricing Information -->
                    <div class="card mb-3">
                        <div class="card-header bg-success text-white">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-dollar-sign me-2"></i>Pricing
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-bold">Rental Price:</span>
                                <span class="text-success fw-bold">${{ number_format($book->rental_price_per_day, 2) }}/day</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">Security Deposit:</span>
                                <span class="text-warning fw-bold">${{ number_format($book->security_deposit, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Owner Information -->
                    <div class="card mb-3">
                        <div class="card-header bg-info text-white">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-user me-2"></i>Owner Information
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($book->lender_id && $book->lender)
                                <div class="text-center">
                                    <div class="mb-2">
                                        <i class="fas fa-user-circle fa-3x text-info"></i>
                                    </div>
                                    <h6 class="fw-bold">{{ $book->lender->name }}</h6>
                                    <p class="text-muted mb-1">{{ $book->lender->email }}</p>
                                    @if($book->lender->phone)
                                        <p class="text-muted mb-0">{{ $book->lender->phone }}</p>
                                    @endif
                                </div>
                            @else
                                <div class="text-center">
                                    <div class="mb-2">
                                        <i class="fas fa-user-shield fa-3x text-warning"></i>
                                    </div>
                                    <h6 class="fw-bold text-warning">Admin Added</h6>
                                    <p class="text-muted mb-0">No specific owner</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-clock me-2"></i>Timestamps
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-bold">Added:</span>
                                <span>{{ $book->created_at->format('M d, Y \a\t h:i A') }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">Last Updated:</span>
                                <span>{{ $book->updated_at->format('M d, Y \a\t h:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('admin.books') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to Books
                            </a>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-1"></i> Edit Book
                            </a>
                            <button type="button" 
                                    class="btn btn-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal">
                                <i class="fas fa-trash me-1"></i> Delete Book
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Delete Book
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-trash-alt fa-4x text-danger mb-3"></i>
                    <h5>Are you sure you want to delete this book?</h5>
                    <p class="text-muted">
                        "<strong>{{ $book->title }}</strong>" by {{ $book->author }}
                    </p>
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
                <form action="{{ route('admin.books.destroy', $book) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Delete Book
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 1rem;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.table-borderless td {
    border: none;
    padding: 0.75rem 0.5rem;
}

.badge {
    font-size: 0.8rem;
    padding: 0.5rem 0.75rem;
    border-radius: 20px;
}

.btn {
    padding: 10px 20px;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.img-fluid {
    transition: transform 0.3s ease;
}

.img-fluid:hover {
    transform: scale(1.05);
}

.modal-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
}

.modal-header {
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.alert {
    border-radius: 10px;
    border: none;
}

.alert-warning {
    background-color: #fff3cd;
    color: #856404;
}

/* Icon colors */
.text-primary { color: #007bff !important; }
.text-success { color: #28a745 !important; }
.text-info { color: #17a2b8 !important; }
.text-warning { color: #ffc107 !important; }
.text-danger { color: #dc3545 !important; }
.text-muted { color: #6c757d !important; }

/* Responsive design */
@media (max-width: 768px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .d-flex.gap-2 {
        flex-direction: column;
        gap: 0.5rem !important;
    }
}
</style>
@endsection
