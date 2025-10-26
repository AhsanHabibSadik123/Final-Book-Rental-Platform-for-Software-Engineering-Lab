<!-- This page is use for confirming book rental from user. -->
@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-warning">
                        <h4 class="mb-0">Confirm Rental</h4>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @php
                            $rentalAmount = (float) $book->rental_price_per_day * (int) $days;
                            $deposit = (float) $book->security_deposit;
                            $grandTotal = $rentalAmount + $deposit;
                        @endphp

                        <div class="mb-3">
                            <h5 class="mb-1">{{ $book->title }}</h5>
                            <p class="mb-1"><strong>Days:</strong> {{ $days }}</p>
                            <p class="mb-1"><strong>Per-day Price:</strong>
                                {{ number_format($book->rental_price_per_day, 2) }}</p>
                            <p class="mb-1"><strong>Rental Amount:</strong>
                                {{ number_format($rentalAmount, 2) }}</p>

                            <p class="mb-1"><strong>Security Deposit:</strong> {{ number_format($deposit, 2) }}</p>
                            <hr>
                            <h5 class="mb-0">Total: {{ number_format($grandTotal, 2) }}</h5>
                        </div>

                        <form method="POST" action="{{ route('books.rent.process', $book->id) }}">
                            @csrf
                            <input type="hidden" name="days" value="{{ $days }}">
                            <input type="hidden" name="confirm" value="1">

                            <button type="submit" class="btn btn-primary">Confirm and Rent</button>
                            <a href="{{ route('books.rent', $book->id) }}" class="btn btn-secondary ms-2">Go Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection