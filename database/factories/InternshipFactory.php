<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employer;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Internship>
 */
class InternshipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employer_id' => Employer::factory(),
            'title' => fake()->jobTitle() . ' Intern',
            'salary' => fake()->randomElement([
                '$15-20/hour', 
                '$1,500/month', 
                '$2,000/month', 
                '$2,500/month', 
                'Unpaid'
            ]),
            'location' => fake()->city() . ', ' . fake()->stateAbbr(),
            'schedule' => fake()->randomElement(['Full-time', 'Part-time', 'Remote', 'Hybrid']),
            'description' => fake()->paragraphs(3, true),
            'duration' => fake()->randomElement([
                '3 months', 
                'Summer 2025', 
                'Fall 2025', 
                '6 months', 
                'Ongoing'
            ]),
            'deadline_date' => fake()->dateTimeBetween('+1 week', '+3 months'),
            'featured' => fake()->boolean(20), // 20% chance of being featured
        ];
    }
    
    /**
     * Indicate that the internship is featured.
     */
    public function featured()
    {
        return $this->state(function (array $attributes) {
            return [
                'featured' => true,
            ];
        });
    }
    
    /**
     * Create an internship with immediate deadline_date.
     */
    public function urgent()
    {
        return $this->state(function (array $attributes) {
            return [
                'deadline_date' => Carbon::now()->addDays(fake()->numberBetween(2, 7)),
            ];
        });
    }
}