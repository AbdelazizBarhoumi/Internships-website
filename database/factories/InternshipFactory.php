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
        // Create employer with specific timestamp
        $employerCreatedAt = fake()->dateTimeBetween('2024-12-01', '-1 day');
        $internshipCreatedAt = fake()->dateTimeBetween($employerCreatedAt, 'now');
        
        // Create employer with its own timestamp
        $employer = Employer::factory()
            ->state(function (array $attributes) use ($employerCreatedAt) {
                return [
                    'created_at' => $employerCreatedAt,
                    'updated_at' => $employerCreatedAt
                ];
            })
            ->withoutLogo()
            ->create();
        
        // Set deadline date to be between the internship creation date and 3 months after
        $deadlineDate = fake()->dateTimeBetween(
            Carbon::instance($internshipCreatedAt)->addDays(7), // Earliest deadline is 1 week after posting
            Carbon::instance($internshipCreatedAt)->addMonths(3) // Latest deadline is 3 months after posting
        );
        
        return [
            'employer_id' => $employer->id,
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
            'deadline_date' => $deadlineDate,
            'featured' => fake()->boolean(20), // 20% chance of being featured
            'is_active' => fake()->boolean(90), // 90% chance of being active
            'view_count' => fake()->numberBetween(0, 500), // Random view count between 0 and 500
            'created_at' => $internshipCreatedAt,
            'updated_at' => $internshipCreatedAt,
        ];
    }
    
    /**
     * Create an internship with immediate deadline_date.
     */
    public function urgent()
    {
        return $this->state(function (array $attributes) {
            // Get the internship creation date and add 2-7 days for urgent deadlines
            $creationDate = $attributes['created_at'] instanceof \DateTime 
                ? Carbon::instance($attributes['created_at']) 
                : new Carbon($attributes['created_at']);
                
            return [
                'deadline_date' => $creationDate->copy()->addDays(fake()->numberBetween(2, 7)),
            ];
        });
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
     * Create an active internship.
     */
    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => true,
            ];
        });
    }
    
    /**
     * Create an inactive internship.
     */
    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => false,
            ];
        });
    }
    
    /**
     * Create a popular internship with high view count.
     */
    public function popular()
    {
        return $this->state(function (array $attributes) {
            return [
                'view_count' => fake()->numberBetween(1000, 5000),
            ];
        });
    }
    
    /**
     * Create a remote internship.
     */
    public function remote()
    {
        return $this->state(function (array $attributes) {
            return [
                'schedule' => 'Remote',
                'location' => 'Remote',
            ];
        });
    }
    
    /**
     * Create a paid internship.
     */
    public function paid()
    {
        return $this->state(function (array $attributes) {
            return [
                'salary' => '$' . fake()->numberBetween(15, 30) . '/hour',
            ];
        });
    }
    
    /**
     * Create an unpaid internship.
     */
    public function unpaid()
    {
        return $this->state(function (array $attributes) {
            return [
                'salary' => 'Unpaid',
            ];
        });
    }
    
    /**
     * Set a custom date range for internship creation
     * while ensuring the employer was created before the internship
     */
    public function createdBetween(string $startDate, string $endDate): static
    {
        return $this->state(function (array $attributes) use ($startDate, $endDate) {
            // Get the employer
            $employer = Employer::find($attributes['employer_id']);
            
            // Get the employer created_at date
            $employerCreatedAt = $employer->created_at;
            
            // Ensure internship date is after employer creation date
            $startDateObj = new Carbon($startDate);
            $effectiveStartDate = $employerCreatedAt->gt($startDateObj) 
                ? $employerCreatedAt->format('Y-m-d') 
                : $startDate;
                
            $createdAt = fake()->dateTimeBetween($effectiveStartDate, $endDate);
            
            return [
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        });
    }
    
    /**
     * Create an internship with a recent creation date (last 30 days)
     * while ensuring the employer was created before the internship
     */
    public function recent(): static
    {
        return $this->state(function (array $attributes) {
            // Get the employer
            $employer = Employer::find($attributes['employer_id']);
            
            // Get the employer created_at date
            $employerCreatedAt = $employer->created_at;
            
            // Determine the effective start date (max of employer creation and 30 days ago)
            $thirtyDaysAgo = now()->subDays(30);
            $effectiveStartDate = $employerCreatedAt->gt($thirtyDaysAgo) 
                ? $employerCreatedAt->format('Y-m-d') 
                : $thirtyDaysAgo->format('Y-m-d');
                
            $createdAt = fake()->dateTimeBetween($effectiveStartDate, now());
            
            return [
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        });
    }
    
    /**
     * Create an internship for an existing employer
     */
    public function forEmployer(int $employerId): static
    {
        return $this->state(function (array $attributes) use ($employerId) {
            $employer = Employer::find($employerId);
            
            if (!$employer) {
                throw new \InvalidArgumentException("Employer with ID {$employerId} not found");
            }
            
            return [
                'employer_id' => $employerId,
                // Ensure internship is created after employer
                'created_at' => fake()->dateTimeBetween($employer->created_at, 'now'),
                'updated_at' => function (array $attributes) {
                    return $attributes['created_at'];
                },
            ];
        });
    }
}