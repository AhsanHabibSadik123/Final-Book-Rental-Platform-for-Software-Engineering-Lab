@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Rent Book: {{ $book->title }}</h4>
                    <span class="badge bg-warning text-dark">
                        <i class="fas fa-wallet me-1"></i> Balance: ${{ number_format(Auth::user()->wallet ?? 0, 2) }}
                    </span>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form method="POST" action="{{ route('books.rent.process', $book->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="days" class="form-label">Number of Days</label>
                            <input type="number" name="days" id="days" class="form-control" min="1" max="30" required value="{{ old('days', 1) }}">
                            <small class="text-muted">Max 30 days per rental.</small>
                        </div>
                        <div class="mb-3">
                            <strong>Rental Price/Day:</strong> {{ number_format($book->rental_price_per_day, 2) }}<br>
                            <strong>Security Deposit:</strong> {{ number_format($book->security_deposit, 2) }}
                        </div>
                        <button type="submit" class="btn btn-success">Proceed to Confirmation</button>
                        <a href="{{ route('books.browse') }}" class="btn btn-secondary ms-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
