<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'bio',
        'role',
        'wallet',
        'is_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a regular user (can both lend and borrow)
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Check if user can lend books (all non-admin users can lend)
     */
    public function canLend(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Check if user can borrow books (all non-admin users can borrow)
     */
    public function canBorrow(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Books owned by this lender
     */
    public function books()
    {
        return $this->hasMany(Book::class, 'lender_id');
    }

    /**
     * Rentals as borrower
     */
    public function borrowedRentals()
    {
        return $this->hasMany(Rental::class, 'borrower_id');
    }

    /**
     * Rentals as borrower (alternative name for withCount)
     */
    public function rentalsAsBorrower()
    {
        return $this->hasMany(Rental::class, 'borrower_id');
    }

    /**
     * Rentals as lender
     */
    public function lentRentals()
    {
        return $this->hasMany(Rental::class, 'lender_id');
    }

    /**
     * Rentals as lender (alternative name for withCount)
     */
    public function rentalsAsLender()
    {
        return $this->hasMany(Rental::class, 'lender_id');
    }
}
