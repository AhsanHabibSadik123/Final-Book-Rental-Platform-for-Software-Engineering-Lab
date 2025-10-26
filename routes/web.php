<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

// Home page
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Unified user dashboard (replaces separate lender/borrower dashboards)
    Route::get('/user-dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/my-books', function () {
        return view('user.myBooks');
    })->name('user.myBooks');

    Route::get('/profile', function () {
        return view('user.profile');
    })->name('profile');
    Route::get('/profile/edit', [DashboardController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/edit', [DashboardController::class, 'updateProfile'])->name('profile.update');

    // Debug route to check user role
    Route::get('/debug-user', function () {
        $user = Auth::user();
        return response()->json([
            'authenticated' => Auth::check(),
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : null,
            'user_email' => $user ? $user->email : null,
            'user_role' => $user ? $user->role : null,
        ]);
    });

    // Book Routes (exclude create since view was removed)
    Route::resource('books', BookController::class)->except(['create']);
    Route::get('books/{book}/rent', [BookController::class, 'showRentForm'])->name('books.rent');
    Route::post('books/{book}/rent', [BookController::class, 'processRent'])->name('books.rent.process');
    Route::get('my-rentals', [BookController::class, 'myRentals'])->name('user.myRentals');
    Route::get('/browse-books', [BookController::class, 'browse'])->name('books.browse');
    // Removed books.home route because the user.home view was deleted

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Book Management Routes (New System)
        Route::get('/books', [AdminController::class, 'books'])->name('books');
        Route::get('/books/create', [AdminController::class, 'createBook'])->name('books.create');
        Route::post('/books', [AdminController::class, 'storeBook'])->name('books.store');
        Route::get('/books/{book}', [AdminController::class, 'showBook'])->name('books.show');
        Route::get('/books/{book}/edit', [AdminController::class, 'editBook'])->name('books.edit');
        Route::put('/books/{book}', [AdminController::class, 'updateBook'])->name('books.update');
        Route::delete('/books/{book}', [AdminController::class, 'deleteBook'])->name('books.destroy');
    Route::post('/books/{book}/return', [AdminController::class, 'returnBookFromUser'])->name('books.return');

        // User Management Routes
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
        Route::patch('/users/{user}/status', [AdminController::class, 'updateUserStatus'])->name('users.update-status');
        Route::patch('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.update-role');
        Route::patch('/users/{user}/wallet', [AdminController::class, 'updateUserWallet'])->name('users.update-wallet');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    });
});
