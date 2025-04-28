<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employer>
 */
class EmployerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employer_name' => fake()->company,
            'employer_email' => fake()->unique()->safeEmail,
            'employer_logo' => fake()->imageUrl(),
            'user_id' => User::factory(),
        ];
    }
}
