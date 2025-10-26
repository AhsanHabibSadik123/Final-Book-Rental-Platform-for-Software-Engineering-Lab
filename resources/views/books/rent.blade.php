<!-- This page is use for renting a book from the library for the user. -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4>Rent Book: {{ $book->title }}</h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @error('days')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="mb-3">
                        <p class="mb-1"><strong>Author:</strong> {{ $book->author }}</p>
                        <p class="mb-1"><strong>Genre:</strong> {{ $book->genre }}</p>
                        <p class="mb-1"><strong>Per-day Price:</strong> {{ number_format($book->rental_price_per_day, 2) }}</p>
                        <p class="mb-0"><strong>Security Deposit:</strong> {{ number_format($book->security_deposit, 2) }}</p>
                    </div>

                    <form method="POST" action="{{ route('books.rent.process', $book->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="days" class="form-label">Number of Days</label>
                            <input type="number" name="days" id="days" class="form-control" min="1" max="30" required value="{{ old('days', 1) }}">
                            <small class="text-muted">Max 30 days per rental.</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Proceed to Confirmation</button>
                        <a href="{{ route('books.browse') }}" class="btn btn-secondary ms-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
