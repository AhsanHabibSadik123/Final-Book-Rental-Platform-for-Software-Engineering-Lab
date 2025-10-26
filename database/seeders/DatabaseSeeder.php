<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Rental;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    // Reset tables safely respecting foreign keys
    Schema::disableForeignKeyConstraints();
    // Rental::truncate();
    // Book::truncate();
    // User::truncate();
    Schema::enableForeignKeyConstraints();

    // Seed admin and baseline users first
    // $this->call(AdminUserSeeder::class);
    // User::factory(30)->create();

    // Seed books (BookFactory should assign valid lender_id values)
    Book::factory(1000)->create();

    }
}
