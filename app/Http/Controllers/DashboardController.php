<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show the edit profile form
     */
    public function editProfile()
    {
        return view('user.edit-profile');
    }

    /**
     * Handle profile update
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        /** @var \App\Models\User|null $user */
        if (!$user instanceof User) {
            return redirect()->route('login');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:1000',
            // Password change fields (optional)
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            // Only fill allowed fields and save, avoiding any mass-assignment edge cases
            $user->fill([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'bio' => $validated['bio'] ?? null,
            ]);

            // If user requested a password change
            if ($request->filled('password')) {
                // Require current password and verify it
                if (!$request->filled('current_password')) {
                    return back()->withInput()->withErrors([
                        'current_password' => 'Please enter your current password to change it.',
                    ]);
                }

                if (!Hash::check($request->input('current_password'), $user->password)) {
                    return back()->withInput()->withErrors([
                        'current_password' => 'The current password is incorrect.',
                    ]);
                }

                // Passed verification; update password
                $user->password = Hash::make($request->input('password'));
            }

            $user->save();

            return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    } catch (\Throwable $e) {
            // Log the error for debugging and show a friendly message
            Log::error('Profile update failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return back()->withInput()->withErrors([
                'profile' => 'Could not update profile. Please try again.',
            ]);
        }
    }
    /**
     * Show the dashboard - redirect to role-specific dashboard
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user instanceof User) {
            return redirect()->route('login');
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Only other role is 'user'
        return $this->userDashboard($request);
    }

    /**
     * User Dashboard - Show unified dashboard for lending and borrowing
     */
    public function userDashboard(Request $request)
    {
        $user = Auth::user();
        
    // Get user statistics (borrower-centric)
    $stats = $this->getUserStats($user);

    // Lender-specific list removed in two-role model; keep for view compatibility as empty
    $myBooks = collect();

    // Get user's rentals (as borrower)
    $myRentals = Rental::where('borrower_id', $user->id)
              ->with(['book', 'book.lender'])
              ->latest()
              ->take(5)
              ->get();

    return view('user.userDashboard', compact('stats', 'myBooks', 'myRentals'));
    }
    
    /**
     * Get comprehensive user statistics from database
     */
    private function getUserStats($user)
    {
    // Rental statistics (as borrower)
        $myRentals = Rental::where('borrower_id', $user->id)->count();
        $activeRentals = Rental::where('borrower_id', $user->id)
                              ->where('status', 'active')
                              ->count();
        
        // Due soon rentals (due within next 7 days)
        $dueSoon = Rental::where('borrower_id', $user->id)
                        ->where('status', 'active')
                        ->where('rental_end_date', '<=', Carbon::now()->addDays(7))
                        ->where('rental_end_date', '>=', Carbon::now())
                        ->count();
        
        // Total spent on rentals
        $totalSpent = Rental::where('borrower_id', $user->id)
                           ->where('status', 'completed')
                           ->sum('total_amount');
        
        // Overdue rentals
        $overdueRentals = Rental::where('borrower_id', $user->id)
                               ->where('status', 'active')
                               ->where('rental_end_date', '<', Carbon::now())
                               ->count();
        
        // Total available books in system
        $totalAvailableBooks = Book::where('status', 'available')->count();
        
        return [
            // Borrower stats
            'my_rentals' => $myRentals,
            'active_rentals' => $activeRentals,
            'due_soon' => $dueSoon,
            'total_spent' => $totalSpent,
            'overdue_rentals' => $overdueRentals,
            
            // General stats
            'total_available_books' => $totalAvailableBooks,
        ];
    }
}
