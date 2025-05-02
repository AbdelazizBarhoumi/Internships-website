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
            'user_id' => User::factory(),
            'employer_name' => fake()->company(),
            'employer_email' => fake()->unique()->companyEmail(),
            'employer_logo' => fake()->imageUrl(),
            'industry' => fake()->randomElement([
                'Technology',
                'Finance',
                'Healthcare',
                'Education',
                'Marketing',
                'Engineering',
                'Media',
                'Retail',
                'Manufacturing',
                'Hospitality',
                'Legal',
                'Non-profit'
            ]),
            'location' => fake()->city() . ', ' . fake()->stateAbbr(),
            'description' => fake()->paragraphs(2, true),
            'website' => fake()->url(),
            'phone' => fake()->phoneNumber(),
        ];
    }
    
    /**
     * Configure the model factory to create an employer without a logo.
     *
     * @return $this
     */
    public function withoutLogo()
    {
        return $this->state(function (array $attributes) {
            return [
                'employer_logo' => null,
            ];
        });
    }
    
    /**
     * Configure the model factory to create an employer with a specific industry.
     *
     * @param string $industry
     * @return $this
     */
    public function industry(string $industry)
    {
        return $this->state(function (array $attributes) use ($industry) {
            return [
                'industry' => $industry,
            ];
        });
    }
}