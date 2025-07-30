<?php

namespace Database\Factories;

use App\Models\BooksModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BooksFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = BooksModel::class;

    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'description' => fake()->sentence(),
            'counts' => fake()->randomNumber(2),
            'cover' => 'https://raw.githubusercontent.com/fedeperin/potterapi/main/public/images/covers/' . random_int(1, 8) . '.png'
        ];
    }
}
