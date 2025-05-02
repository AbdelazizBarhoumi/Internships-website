<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Student;
use App\Models\Internship;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get random education level
        $education = fake()->randomElement(['high_school', 'associate', 'bachelor', 'master', 'phd']);
        
        // Generate institution based on education level
        $institution = match($education) {
            'high_school' => fake()->randomElement([
                'Central High School', 'Washington High School', 'Lincoln Academy', 
                'Jefferson High School', 'Roosevelt High School'
            ]),
            'associate' => fake()->randomElement([
                'Community College of Denver', 'Santa Monica College', 
                'Austin Community College', 'Miami Dade College'
            ]),
            default => fake()->randomElement([
                'University of California', 'Stanford University', 'MIT', 
                'Harvard University', 'Georgia Tech', 'University of Michigan',
                'University of Texas', 'NYU', 'Columbia University', 'Ohio State University'
            ])
        };
        
        // Generate random skills list
        $skills = [
            'JavaScript', 'Python', 'Java', 'React', 'SQL', 'Communication',
            'Teamwork', 'Problem-solving', 'Time Management', 'Microsoft Office',
            'Adobe Creative Suite', 'Project Management', 'Customer Service',
            'Data Analysis', 'Research', 'Critical Thinking', 'Adaptability'
        ];
        
        $randomSkills = fake()->randomElements($skills, fake()->numberBetween(4, 8));
        
        // Create a timestamp for user - must be earlier than everything else
        $userCreatedAt = fake()->dateTimeBetween('2024-12-01', '-1 week');
        
        // Generate random user with student profile - using specific timestamp
        $user = User::factory()
            ->has(
                Student::factory([
                    'education_level' => $education,
                    'institution' => $institution,
                    'skills' => implode(', ', $randomSkills)
                ])
                ->state(function (array $attributes) use ($userCreatedAt) {
                    return [
                        'created_at' => $userCreatedAt,
                        'updated_at' => $userCreatedAt
                    ];
                })
            )
            ->state(function (array $attributes) use ($userCreatedAt) {
                return [
                    'created_at' => $userCreatedAt,
                    'updated_at' => $userCreatedAt
                ];
            })
            ->create();
            
        // Create internship with its own timestamp after user creation
        $internship = Internship::factory()
            ->state(function (array $attributes) use ($userCreatedAt) {
                // Internship must be created after the user, but before now
                $internshipCreatedAt = fake()->dateTimeBetween($userCreatedAt, 'now');
                
                return [
                    'created_at' => $internshipCreatedAt,
                    'updated_at' => $internshipCreatedAt
                ];
            })
            ->create();
            
        // Application timestamp must be after both user and internship creation
        $applicationCreatedAt = fake()->dateTimeBetween(
            $internship->created_at, // Must be after internship was posted
            now() // Up to the current time
        );
        
        return [
            'user_id' => $user->id,
            'internship_id' => $internship->id,
            'phone' => fake()->phoneNumber(),
            'availability' => fake()->dateTimeBetween('+1 week', '+3 months'),
            'education' => $education,
            'institution' => $institution,
            'skills' => implode(', ', $randomSkills),
            'resume_path' => 'resumes/' . fake()->uuid() . '.pdf',
            'cover_letter' => fake()->boolean(70) ? fake()->paragraphs(3, true) : null,
            'transcript_path' => fake()->boolean(40) ? 'transcripts/' . fake()->uuid() . '.pdf' : null,
            'why_interested' => fake()->paragraphs(2, true),
            'status' => fake()->randomElement(['pending', 'reviewing', 'interviewed', 'accepted', 'rejected']),
            'notes' => fake()->boolean(30) ? fake()->paragraph() : null,
            'admin_notes' => fake()->boolean(20) ? fake()->paragraph() : null,
            'created_at' => $applicationCreatedAt,
            'updated_at' => $applicationCreatedAt,
        ];
    }
    public function forInternship(int $internshipId)
    {
        return $this->state(function (array $attributes) use ($internshipId) {
            $internship = Internship::find($internshipId);
            
            if (!$internship) {
                throw new \InvalidArgumentException("Internship with ID {$internshipId} not found");
            }
            
            // Ensure application was created after internship posting
            $createdAt = fake()->dateTimeBetween($internship->created_at, 'now');
            
            return [
                'internship_id' => $internshipId,
                'created_at' => $createdAt,
                'updated_at' => $createdAt
            ];
        });
    }
    /**
     * Configure the model factory to create an application with pending status.
     *
     * @return $this
     */
    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending',
                'admin_notes' => null,
            ];
        });
    }
    
    /**
     * Configure the model factory to create an application that's currently being reviewed.
     *
     * @return $this
     */
    public function reviewing()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'reviewing',
                'admin_notes' => fake()->sentence(),
            ];
        });
    }
    
    /**
     * Configure the model factory to create an application that's been interviewed.
     *
     * @return $this
     */
    public function interviewed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'interviewed',
                'admin_notes' => fake()->paragraphs(2, true),
            ];
        });
    }
    
    /**
     * Configure the model factory to create an accepted application.
     *
     * @return $this
     */
    public function accepted()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'accepted',
                'admin_notes' => 'Candidate accepted. ' . fake()->sentence(),
            ];
        });
    }
    
    /**
     * Configure the model factory to create a rejected application.
     *
     * @return $this
     */
    public function rejected()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'rejected',
                'admin_notes' => 'Candidate not selected. ' . fake()->sentence(),
            ];
        });
    }
    
    /**
     * Configure the model factory to create an application for a specific user.
     *
     * @param int $userId
     * @return $this
     */
    public function forUser(int $userId)
    {
        return $this->state(function (array $attributes) use ($userId) {
            $user = User::find($userId);
            $student = $user->student;
            
            if ($student) {
                return [
                    'user_id' => $userId,
                    'phone' => $student->phone ?? fake()->phoneNumber(),
                    'education' => $student->education_level,
                    'institution' => $student->institution,
                    'skills' => $student->skills,
                    'resume_path' => $student->resume_path ?? 'resumes/' . fake()->uuid() . '.pdf',
                ];
            } else {
                return [
                    'user_id' => $userId,
                ];
            }
        });
    }
    

    
    /**
     * Configure the model factory to create an application with complete documentation.
     *
     * @return $this
     */
    public function withCompleteDocumentation()
    {
        return $this->state(function (array $attributes) {
            return [
                'resume_path' => 'resumes/' . fake()->uuid() . '.pdf',
                'cover_letter' => fake()->paragraphs(3, true),
                'transcript_path' => 'transcripts/' . fake()->uuid() . '.pdf',
            ];
        });
    }
    /**
     * Create an application for an existing student
     * This avoids creating a new student and ensures proper timestamps
     */
    public function forExistingStudent(int $studentId): static
    {
        return $this->state(function (array $attributes) use ($studentId) {
            $student = Student::with('user')->find($studentId);
            
            if (!$student) {
                throw new \InvalidArgumentException("Student with ID {$studentId} not found");
            }
            
            return [
                'user_id' => $student->user_id,
                'education' => $student->education_level,
                'institution' => $student->institution,
                'skills' => $student->skills,
                'phone' => $student->phone ?? fake()->phoneNumber(),
                'resume_path' => $student->resume_path ?? 'resumes/' . fake()->uuid() . '.pdf',
                // Ensure application is created after student
                'created_at' => fake()->dateTimeBetween($student->created_at, 'now'),
            ];
        });
    }
    
public function createdBetween(string $startDate, string $endDate): static
    {
        return $this->state(function (array $attributes) use ($startDate, $endDate) {
            // Get the user and internship
            $user = User::find($attributes['user_id']);
            $internship = Internship::find($attributes['internship_id']);
            
            // Get the creation dates
            $userCreatedAt = $user->created_at;
            $internshipCreatedAt = $internship->created_at;
            
            // The application must be created after both user and internship
            $latestPrerequisiteDate = $userCreatedAt->gt($internshipCreatedAt) 
                ? $userCreatedAt 
                : $internshipCreatedAt;
                
            // Ensure our start date is after all prerequisites
            $startDateObj = new Carbon($startDate);
            $effectiveStartDate = $latestPrerequisiteDate->gt($startDateObj) 
                ? $latestPrerequisiteDate->format('Y-m-d') 
                : $startDate;
                
            $createdAt = fake()->dateTimeBetween($effectiveStartDate, $endDate);
            
            return [
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        });
    }
    
    /**
     * Create an application with a recent creation date (last 14 days)
     * while ensuring proper timeline (student → internship → application)
     */
    public function recent(): static
    {
        return $this->state(function (array $attributes) {
            // Get the user and internship
            $user = User::find($attributes['user_id']);
            $internship = Internship::find($attributes['internship_id']);
            
            // Get the creation dates
            $userCreatedAt = $user->created_at;
            $internshipCreatedAt = $internship->created_at;
            
            // The application must be created after both user and internship
            $latestPrerequisiteDate = $userCreatedAt->gt($internshipCreatedAt) 
                ? $userCreatedAt 
                : $internshipCreatedAt;
                
            // Determine the effective start date (max of prerequisites and 14 days ago)
            $twoWeeksAgo = now()->subDays(14);
            $effectiveStartDate = $latestPrerequisiteDate->gt($twoWeeksAgo) 
                ? $latestPrerequisiteDate 
                : $twoWeeksAgo;
                
            $createdAt = fake()->dateTimeBetween($effectiveStartDate, now());
            
            return [
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        });
    }
}