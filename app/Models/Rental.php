<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'borrower_id',
        'lender_id',
        'rental_start_date',
        'rental_end_date',
    'rental_days',
        'actual_return_date',
        'daily_rate',
        'total_amount',
        'security_deposit',
        'status',
        'notes',
    ];

    protected $casts = [
        'rental_start_date' => 'date',
        'rental_end_date' => 'date',
        'actual_return_date' => 'date',
        'daily_rate' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'security_deposit' => 'decimal:2',
    'rental_days' => 'integer',
    ];

    /**
     * Rental belongs to a book
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Rental belongs to a borrower
     */
    public function borrower()
    {
        return $this->belongsTo(User::class, 'borrower_id');
    }

    /**
     * Rental belongs to a lender
     */
    public function lender()
    {
        return $this->belongsTo(User::class, 'lender_id');
    }

    /**
     * Check if rental is overdue
     */
    public function isOverdue(): bool
    {
        return $this->status === 'active' && 
               Carbon::now()->greaterThan($this->rental_end_date);
    }

    /**
     * Calculate late fee
     */
    public function calculateLateFee(): float
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        $daysLate = Carbon::now()->diffInDays($this->rental_end_date);
        return $daysLate * ($this->daily_rate * 0.5); // 50% of daily rate as late fee
    }

    /**
     * Get rental duration in days
     */
    public function getDurationInDays(): int
    {
        return \Carbon\Carbon::parse($this->rental_start_date)
            ->diffInDays(\Carbon\Carbon::parse($this->rental_end_date));
    }

    /**
     * Scope for active rentals
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for overdue rentals
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'active')
                    ->where('rental_end_date', '<', Carbon::now());
    }
}
