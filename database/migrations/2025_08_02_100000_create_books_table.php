<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('isbn')->nullable();
            $table->text('description')->nullable();
            $table->string('genre');
            $table->string('condition')->default('good'); // new, good, fair, poor
            $table->string('image_path')->nullable();
            $table->decimal('rental_price_per_day', 8, 2);
            $table->decimal('security_deposit', 8, 2)->default(0);
            $table->integer('rental_duration_max_days')->default(30);
            $table->boolean('is_available')->default(true);
            $table->foreignId('lender_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['available', 'rented', 'maintenance', 'unavailable'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
