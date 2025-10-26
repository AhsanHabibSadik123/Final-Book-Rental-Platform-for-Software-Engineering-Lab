<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // u7se Faker to generate fake data for books
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name(),
            'isbn' => $this->faker->unique()->isbn13(),
            'description' => $this->faker->paragraph(),
            'genre' => $this->faker->randomElement(['Fiction', 'Non-Fiction', 'Science Fiction', 'Biography', 'Mystery', 'Fantasy']),
            'condition' => $this->faker->randomElement(['New', 'Like New', 'Good', 'Fair', 'Poor']),
            'image_path' => $this->faker->imageUrl(200, 300, 'books', true),
            'rental_price_per_day' => $this->faker->randomFloat(2, 1, 20),
            'security_deposit' => $this->faker->randomFloat(2, 5, 100),
            'rental_duration_max_days' => $this->faker->numberBetween(7, 30),
            'lender_id' => $this->faker->numberBetween(2, 15), // Assuming user IDs from 1 to 30
            'status' => 'available',    
        ];
    }
}
