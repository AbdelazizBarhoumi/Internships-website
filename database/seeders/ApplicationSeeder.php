<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Internship;
use App\Models\User;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating applications with various statuses...');
        
        // First, check if we have students and internships
        $studentCount = Student::count();
        $internshipCount = Internship::where('is_active', true)->count();
        
        if ($studentCount < 10) {
            $this->command->info('Creating additional students for applications...');
            User::factory()
                ->count(max(10 - $studentCount, 0))
                ->has(Student::factory())
                ->create();
        }
        
        if ($internshipCount < 5) {
            $this->command->info('Creating additional internships for applications...');
            Internship::factory()
                ->count(max(5 - $internshipCount, 0))
                ->active()
                ->create();
        }
        
        // Get active internships
        $activeInternships = Internship::where('is_active', true)->get();
        
        // Get students with their users
        $students = Student::with('user')->get();
        
        // Ensure we don't create duplicate applications for the same user-internship pair
        $existingPairs = DB::table('applications')
            ->select('user_id', 'internship_id')
            ->get()
            ->map(function ($item) {
                return $item->user_id . '-' . $item->internship_id;
            })
            ->toArray();
        
        $this->command->info('Creating pending applications...');
        // Create 40 pending applications
        $this->createApplicationsWithStatus($students, $activeInternships, 'pending', 40, $existingPairs);
        
        $this->command->info('Creating reviewing applications...');
        // Create 30 reviewing applications
        $this->createApplicationsWithStatus($students, $activeInternships, 'reviewing', 30, $existingPairs);
        
        $this->command->info('Creating interviewed applications...');
        // Create 20 interviewed applications
        $this->createApplicationsWithStatus($students, $activeInternships, 'interviewed', 20, $existingPairs);
        
        $this->command->info('Creating accepted applications...');
        // Create 15 accepted applications
        $this->createApplicationsWithStatus($students, $activeInternships, 'accepted', 15, $existingPairs);
        
        $this->command->info('Creating rejected applications...');
        // Create 25 rejected applications
        $this->createApplicationsWithStatus($students, $activeInternships, 'rejected', 25, $existingPairs);
        
        $applicationCount = Application::count();
        $this->command->info("Successfully created a total of {$applicationCount} applications!");
    }
    
    /**
     * Create applications with a specific status
     * 
     * @param \Illuminate\Support\Collection $students
     * @param \Illuminate\Support\Collection $internships
     * @param string $status
     * @param int $count
     * @param array $existingPairs
     */
    private function createApplicationsWithStatus($students, $internships, $status, $count, &$existingPairs)
    {
        $createdCount = 0;
        $maxAttempts = $count * 3; // Prevent infinite loop
        $attempts = 0;
        
        while ($createdCount < $count && $attempts < $maxAttempts) {
            $attempts++;
            
            // Get random student and internship
            $student = $students->random();
            $internship = $internships->random();
            
            // Check if this pair already exists
            $pair = $student->user_id . '-' . $internship->id;
            if (in_array($pair, $existingPairs)) {
                continue; // Skip this pair
            }
            
            // Add to existing pairs to prevent duplicates
            $existingPairs[] = $pair;
            
            // Create application with specified status
            $factory = Application::factory()
                ->forUser($student->user_id)
                ->forInternship($internship->id);
            
            // Apply status-specific factory method
            switch ($status) {
                case 'pending':
                    $factory = $factory->pending();
                    break;
                case 'reviewing':
                    $factory = $factory->reviewing();
                    break;
                case 'interviewed':
                    $factory = $factory->interviewed();
                    break;
                case 'accepted':
                    $factory = $factory->accepted();
                    break;
                case 'rejected':
                    $factory = $factory->rejected();
                    break;
            }
            
            // Create the application
            $factory->create();
            $createdCount++;
        }
        
        if ($createdCount < $count) {
            $this->command->warn("Could only create {$createdCount} of {$count} requested {$status} applications due to unique constraints.");
        } else {
            $this->command->info("Created {$createdCount} {$status} applications.");
        }
    }
}