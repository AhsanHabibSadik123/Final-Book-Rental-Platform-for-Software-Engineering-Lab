<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admin only.');
        }

        $totalBooks = Book::count();
        
        $availableBooks = Book::where('status', 'available')->count();
            
        $rentedBooks = Book::where('status', 'rented')->count();
        
        $totalUsers = User::where('role', '!=', 'admin')->count();
        
        $recentBooks = Book::with('lender')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.adminDashboard', compact(
            'totalBooks', 
            'availableBooks',
            'rentedBooks',
            'totalUsers',
            'recentBooks'
        ));
    }
    public function books(Request $request)
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admin only.');
        }

    $status = $request->get('status', 'all');
    $search = $request->get('search');
        
    $query = Book::with(['lender', 'currentRental.borrower']);

        switch ($status) {
            case 'available':
                $query->where('status', 'available');
                break;
            case 'rented':
                $query->where('status', 'rented');
                break;
            default:
                // All books
                break;
        }

        // Apply search across title/author/genre/description if provided
        if (!empty($search)) {
            $query->search($search);
        }

        $books = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.bookManagement', compact('books', 'status', 'search'));
    }

    public function createBook()
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admin only.');
        }

        return view('admin.books.create');
    }

    public function storeBook(Request $request)
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admin only.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'genre' => 'required|string|max:100',
            'condition' => 'required|in:excellent,very_good,good,fair,poor',
            'rental_price_per_day' => 'required|numeric|min:0',
            'security_deposit' => 'required|numeric|min:0',
            'lender_id' => 'nullable|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->isbn = $request->isbn;
        $book->description = $request->description;
        $book->genre = $request->genre;
        $book->condition = $request->condition;
        $book->rental_price_per_day = $request->rental_price_per_day;
        $book->security_deposit = $request->security_deposit;
    $book->status = 'available';
    // Fallback to current admin if no lender selected (DB requires non-null lender_id)
    $book->lender_id = $request->lender_id ?: Auth::id();

        // Handle image upload (save to public/upload)
        if ($request->hasFile('image')) {
            $destination = public_path('upload');
            if (!is_dir($destination)) {
                mkdir($destination, 0777, true);
            }
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($destination, $imageName);
            $book->image_path = 'upload/' . $imageName; // relative to public
        }

        $book->save();

        return redirect()->route('admin.books')->with('success', 'Book added successfully!');
    }

    public function showBook(Book $book)
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admin only.');
        }

        $book->load(['lender']);
        return view('admin.books.show', compact('book'));
    }

    public function editBook(Book $book)
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admin only.');
        }

        return view('admin.books.edit', compact('book'));
    }

    public function updateBook(Request $request, Book $book)
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admin only.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'genre' => 'required|string|max:100',
            'condition' => 'required|in:excellent,very_good,good,fair,poor',
            'status' => 'required|in:available,rented,maintenance,unavailable',
            'rental_price_per_day' => 'required|numeric|min:0',
            'security_deposit' => 'required|numeric|min:0',
            'lender_id' => 'nullable|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only([
            'title', 'author', 'isbn', 'description', 'genre',
            'condition', 'status', 'rental_price_per_day', 'security_deposit', 'lender_id'
        ]);
        // Prevent accidentally nulling lender_id (HTML may submit empty string)
        if (empty($data['lender_id'])) {
            $data['lender_id'] = $book->lender_id ?: Auth::id();
        }
        $book->update($data);

        // Handle image upload (save to public/upload)
        if ($request->hasFile('image')) {
            // remove old image if exists
            if (!empty($book->image_path)) {
                $old = public_path($book->image_path);
                if (is_file($old)) {
                    @unlink($old);
                }
            }
            $destination = public_path('upload');
            if (!is_dir($destination)) {
                mkdir($destination, 0777, true);
            }
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($destination, $imageName);
            $book->image_path = 'upload/' . $imageName;
            $book->save();
        }

        return redirect()->route('admin.books')->with('success', 'Book updated successfully!');
    }

    public function deleteBook(Book $book)
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admin only.');
        }

        // Remove attached image from public if present
        if (!empty($book->image_path)) {
            $old = public_path($book->image_path);
            if (is_file($old)) {
                @unlink($old);
            }
        }
        $book->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Book deleted successfully!'
            ]);
        }

        return redirect()->route('admin.books')->with('success', 'Book deleted successfully!');
    }

    /**
     * Admin: Return a rented book from the user.
     * - Refund the security deposit to the borrower
     * - Remove the rental record
     * - Mark the book as available
     */
    public function returnBookFromUser(Book $book, Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admin only.');
        }

        // Only process if the book is currently rented
        if ($book->status !== 'rented') {
            return back()->with('error', 'This book is not currently rented.');
        }

        // Find active rental for this book
        $rental = Rental::where('book_id', $book->id)
            ->where('status', 'active')
            ->latest()
            ->first();

        if (!$rental) {
            return back()->with('error', 'Active rental not found for this book.');
        }

    $borrower = $rental->borrower; // user who rented
    $lender = $book->lender;       // book owner
    $adminUser = User::find(Auth::id()); // performing admin as model

        // Determine rental days and cost
        $days = (int)($rental->rental_days ?? 0);
        if ($days <= 0) {
            try {
                $days = max(1, \Carbon\Carbon::parse($rental->rental_start_date)->diffInDays(\Carbon\Carbon::parse($rental->rental_end_date)));
            } catch (\Throwable $e) {
                $days = 1; // fallback
            }
        }
        $dailyRate = (float) $rental->daily_rate;
        $rentalCost = round($dailyRate * $days, 2);
        $deposit = (float) $rental->security_deposit;

        // Calculate shares
    $ownerShare = round($rentalCost * 0.80, 2);
    $adminShare = round($rentalCost - $ownerShare, 2); // ensure sum consistency

        // Detect if rental was prepaid at checkout
        $prepaid = is_string($rental->notes ?? null) && strpos($rental->notes, 'prepaid=1') !== false;

        // Determine if borrower needs to pay extra beyond deposit (only when not prepaid)
        $extraDue = max(0.0, $rentalCost - $deposit);
        if (!$prepaid && $extraDue > 0 && (!$borrower || (float)$borrower->wallet < $extraDue)) {
            return back()->with('error', 'Borrower has insufficient wallet to settle the rental amount.');
        }

        DB::transaction(function () use ($book, $rental, $borrower, $lender, $adminUser, $deposit, $extraDue, $ownerShare, $adminShare, $rentalCost, $prepaid) {
            // Normalize wallets
            if ($borrower) { $borrower->wallet = (float) $borrower->wallet; }
            if ($lender) { $lender->wallet = (float) $lender->wallet; }
            if ($adminUser) { $adminUser->wallet = (float) $adminUser->wallet; }

            if ($prepaid) {
                // Rental was prepaid: refund full deposit and distribute rental cost shares
                if ($borrower) { $borrower->wallet += $deposit; }
                if ($lender) { $lender->wallet += $ownerShare; }
                if ($adminUser) { $adminUser->wallet += $adminShare; }
            } else {
                // Charge borrower extra if deposit insufficient
                if ($extraDue > 0 && $borrower) {
                    $borrower->wallet -= $extraDue;
                }

                // Refund leftover deposit if any
                $leftover = max(0.0, $deposit - $rentalCost);
                if ($leftover > 0 && $borrower) {
                    $borrower->wallet += $leftover;
                }

                // Pay shares
                if ($lender) {
                    $lender->wallet += $ownerShare;
                }
                if ($adminUser) {
                    $adminUser->wallet += $adminShare;
                }
            }

            if ($lender) { $lender->save(); }
            if ($adminUser) { $adminUser->save(); }
            if ($borrower) { $borrower->save(); }

            // Mark the book as available and remove rental
            $book->status = 'available';
            $book->save();

            $rental->delete();
        });

        return redirect()->route('admin.books', ['status' => 'available'])
            ->with('success', 'Book returned. Owner received $'.number_format($ownerShare,2).', admin received $'.number_format($adminShare,2).'.');
    }

    /**
     * List all users
     */
    public function users(Request $request)
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admin only.');
        }

        $search = $request->get('search');
        $role = $request->get('role');
        $status = $request->get('status');

        $query = User::where('role', '!=', 'admin')
            ->withCount(['books', 'rentalsAsBorrower', 'rentalsAsLender']);

        // Add search functionality
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        // Filter by role
        if ($role && $role !== 'all') {
            $query->where('role', $role);
        }

        // Filter by verification status
        if ($status && $status !== 'all') {
            if ($status === 'verified') {
                $query->where('is_verified', true);
            } elseif ($status === 'unverified') {
                $query->where('is_verified', false);
            }
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get statistics
        $stats = [
            'total_users' => User::where('role', '!=', 'admin')->count(),
            'verified_users' => User::where('role', '!=', 'admin')->where('is_verified', true)->count(),
            'lenders' => User::where('role', 'lender')->count(),
            'borrowers' => User::where('role', 'borrower')->count(),
        ];

        return view('admin.users', compact('users', 'stats', 'search', 'role', 'status'));
    }

    /**
     * Show user details
     */
    public function showUser(User $user)
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admin only.');
        }

        // Don't allow viewing other admin users
        if ($user->role === 'admin') {
            abort(403, 'Cannot view admin user details.');
        }

        $user->loadCount(['books', 'rentalsAsBorrower', 'rentalsAsLender']);
        
        // Get user's recent activity
        $recentBooks = $user->books()->latest()->limit(5)->get();
        $recentRentals = $user->rentalsAsBorrower()->with('book')->latest()->limit(5)->get();

        return view('admin.user-details', compact('user', 'recentBooks', 'recentRentals'));
    }

    /**
     * Update user status (verify/unverify)
     */
    public function updateUserStatus(Request $request, User $user)
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admin only.');
        }

        // Don't allow modifying admin users
        if ($user->role === 'admin') {
            abort(403, 'Cannot modify admin users.');
        }

        $request->validate([
            'is_verified' => 'required|boolean',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $oldStatus = $user->is_verified ? 'verified' : 'unverified';
        $newStatus = $request->is_verified ? 'verified' : 'unverified';

        $user->update([
            'is_verified' => $request->is_verified,
        ]);

        Log::info('User status updated by admin', [
            'admin_id' => Auth::id(),
            'user_id' => $user->id,
            'user_name' => $user->name,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'admin_notes' => $request->admin_notes,
        ]);

        // Check if this is an AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "User status updated to {$newStatus} successfully!",
                'new_status' => $newStatus,
                'user_id' => $user->id
            ]);
        }

        return back()->with('success', "User {$user->name} has been {$newStatus} successfully!");
    }

    /**
     * Update user role
     */
    public function updateUserRole(Request $request, User $user)
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admin only.');
        }

        // Don't allow modifying admin users
        if ($user->role === 'admin') {
            abort(403, 'Cannot modify admin users.');
        }

        $request->validate([
            'role' => 'required|in:user',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $oldRole = $user->role;
        $newRole = $request->role;

        $user->update([
            'role' => $newRole,
        ]);

        Log::info('User role updated by admin', [
            'admin_id' => Auth::id(),
            'user_id' => $user->id,
            'user_name' => $user->name,
            'old_role' => $oldRole,
            'new_role' => $newRole,
            'admin_notes' => $request->admin_notes,
        ]);

        // Check if this is an AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "User role updated from {$oldRole} to {$newRole} successfully!",
                'new_role' => $newRole,
                'user_id' => $user->id
            ]);
        }

        return back()->with('success', "User {$user->name} role has been changed from {$oldRole} to {$newRole} successfully!");
    }

    /**
     * Update user wallet balance
     */
    public function updateUserWallet(Request $request, User $user)
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admin only.');
        }

        // Don't allow modifying admin users
        if ($user->role === 'admin') {
            abort(403, 'Cannot modify admin users.');
        }

        $request->validate([
            'action' => 'required|in:add,subtract,set',
            'amount' => 'required|numeric|min:0|max:99999.99',
            'admin_notes' => 'required|string|max:1000',
        ]);

        $oldBalance = $user->wallet;
        $amount = $request->amount;

        switch ($request->action) {
            case 'add':
                $newBalance = $oldBalance + $amount;
                break;
            case 'subtract':
                // Do not allow subtracting more than available balance
                if ($amount > $oldBalance) {
                    if ($request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Cannot subtract more than the user\'s current balance.'
                        ], 422);
                    }
                    return back()->with('error', "Cannot subtract more than the user's current balance.");
                }
                $newBalance = $oldBalance - $amount;
                break;
            case 'set':
                $newBalance = $amount;
                break;
            default:
                return back()->with('error', 'Invalid wallet action.');
                
        }

        $user->update([
            'wallet' => $newBalance,
        ]);

        Log::info('User wallet updated by admin', [
            'admin_id' => Auth::id(),
            'user_id' => $user->id,
            'user_name' => $user->name,
            'action' => $request->action,
            'amount' => $amount,
            'old_balance' => $oldBalance,
            'new_balance' => $newBalance,
            'admin_notes' => $request->admin_notes,
        ]);

        // Check if this is an AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Wallet updated successfully! New balance: $" . number_format($newBalance, 2),
                'new_balance' => $newBalance,
                'user_id' => $user->id
            ]);
        }

        return redirect()->route('admin.users')
            ->with('success', "User {$user->name} wallet has been updated successfully! New balance: $" . number_format($newBalance, 2));
    }

    /**
     * Delete user account
     */
    public function deleteUser(User $user)
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admin only.');
        }

        // Don't allow deleting admin users
        if ($user->role === 'admin') {
            abort(403, 'Cannot delete admin users.');
        }

        // Check if user has active rentals or books
        $hasActiveRentals = $user->rentalsAsBorrower()->whereIn('status', ['active', 'overdue'])->exists();
        $hasBooks = $user->books()->exists();

        if ($hasActiveRentals) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete user with active rentals. Please ensure all rentals are completed first.'
                ], 422);
            }
            return back()->with('error', 'Cannot delete user with active rentals. Please ensure all rentals are completed first.');
        }

        if ($hasBooks) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete user who has listed books. Please remove all books first.'
                ], 422);
            }
            return back()->with('error', 'Cannot delete user who has listed books. Please remove all books first.');
        }

        $userName = $user->name;
        $userEmail = $user->email;

        Log::info('User deleted by admin', [
            'admin_id' => Auth::id(),
            'deleted_user_id' => $user->id,
            'deleted_user_name' => $userName,
            'deleted_user_email' => $userEmail,
        ]);

        $deletedId = $user->id;
        $user->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "User {$userName} ({$userEmail}) has been deleted successfully!",
                'user_id' => $deletedId,
            ]);
        }

        return back()->with('success', "User {$userName} ({$userEmail}) has been deleted successfully!");
    }
}
