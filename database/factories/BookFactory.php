<?php

namespace Database\Factories;

use App\Modules\Books\Database\Book;
use App\Modules\Authors\Database\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid,
            'title' => $this->faker->sentence(3),
            'isbn' => $this->faker->isbn13,
            'available' => true,
            'borrower_name' => null,
            'author_id' => Author::factory(),
            'is_active' => true,
        ];
    }
}
