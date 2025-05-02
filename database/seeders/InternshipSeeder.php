<?php

namespace Database\Seeders;

use App\Models\Internship;
use App\Models\Tag;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Database\Seeder;

class InternshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create predefined tags instead of using factory with unique constraint
        $this->command->info('Creating predefined tags...');
        
        // Define tag categories
        $programmingTags = [
            'JavaScript', 'Python', 'Java', 'PHP', 'C#', 'React', 'Node.js', 
            'Vue.js', 'Angular', 'Laravel', 'Django', 'SQL', 'MongoDB', 
            'AWS', 'Docker', 'Git', 'TypeScript', 'Ruby', 'Go', 'Swift'
        ];
        
        $designTags = [
            'UI/UX Design', 'Graphic Design', 'Web Design', 'Adobe Photoshop',
            'Adobe Illustrator', 'Figma', 'Sketch', 'InDesign', 'After Effects',
            'Motion Graphics', 'Typography', 'Wireframing', 'Prototyping', 
            'User Research', 'Responsive Design'
        ];
        
        $businessTags = [
            'Marketing', 'Digital Marketing', 'SEO', 'Social Media', 'Sales',
            'Business Development', 'Customer Service', 'Data Analysis', 
            'Excel', 'PowerPoint', 'Project Management', 'Agile', 'Scrum',
            'Event Planning', 'Operations'
        ];
        
        $softSkillTags = [
            'Communication', 'Teamwork', 'Problem Solving', 'Critical Thinking',
            'Time Management', 'Organization', 'Leadership', 'Creativity',
            'Adaptability', 'Work Ethic'
        ];
        
        // Create the tags directly in database
        $createdProgrammingTags = collect();
        foreach ($programmingTags as $name) {
            $createdProgrammingTags->push(Tag::create(['name' => $name]));
        }
        
        $createdDesignTags = collect();
        foreach ($designTags as $name) {
            $createdDesignTags->push(Tag::create(['name' => $name]));
        }
        
        $createdBusinessTags = collect();
        foreach ($businessTags as $name) {
            $createdBusinessTags->push(Tag::create(['name' => $name]));
        }
        
        $createdSoftSkillTags = collect();
        foreach ($softSkillTags as $name) {
            $createdSoftSkillTags->push(Tag::create(['name' => $name]));
        }
        
        // Combine all tags
        $allTags = $createdProgrammingTags->concat($createdDesignTags)
                                        ->concat($createdBusinessTags)
                                        ->concat($createdSoftSkillTags);
        
        $this->command->info('Created ' . $allTags->count() . ' tags in different categories');
        
        // Create some employers if none exist
        $employerCount = Employer::count();
        if ($employerCount < 15) {
            $usersWithoutEmployers = User::whereDoesntHave('employer')->take(15 - $employerCount)->get();
            
            foreach ($usersWithoutEmployers as $user) {
                Employer::factory()->create(['user_id' => $user->id]);
            }
            
            // If still not enough employers, create new ones
            if (Employer::count() < 15) {
                Employer::factory(15 - Employer::count())->withoutLogo()->create();
            }
        }
        
        // Get all employer IDs
        $employerIds = Employer::pluck('id')->toArray();
        
        // Create a variety of internships
        $this->command->info('Creating regular internships...');
        
        // Helper function to randomly apply states to a factory
        $applyRandomStates = function($factory) {
            // Randomly apply activity state (90% active by default, but we'll be explicit sometimes)
            if (rand(0, 150) < 20) {
                $factory = $factory->inactive();
            } elseif (rand(0, 150) < 15) {
                $factory = $factory->active();
            }
            
            // 20% chance of being featured (aligns with factory default)
            if (rand(0, 150) < 20) {
                $factory = $factory->featured();
            }
            
            // 15% chance of being urgent
            if (rand(0, 150) < 15) {
                $factory = $factory->urgent();
            }
            
            // 15% chance of being popular with high view count
            if (rand(0, 150) < 15) {
                $factory = $factory->popular();
            }
            
            // 15% chance of being explicitly remote
            if (rand(0, 150) < 15) {
                $factory = $factory->remote();
            }
            
            // 70% chance of being paid, 15% unpaid
            if (rand(0, 150) < 15) {
                $factory = $factory->unpaid();
            } else {
                $factory = $factory->paid();
            }
            
            return $factory;
        };
        
        // Create tech internships (80)
        $this->command->info('Creating tech internships with random states...');
        for ($i = 0; $i < 80; $i++) {
            $factory = Internship::factory()
                ->state(['employer_id' => $employerIds[array_rand($employerIds)]]);
            
            // Apply random states
            $factory = $applyRandomStates($factory);
            
            // Create the internship with applied states
            $internship = $factory->create();
            
            // Attach tags
            $internship->tags()->attach(
                $createdProgrammingTags->shuffle()->take(rand(2, 3))->pluck('id')->toArray()
            );
            $internship->tags()->attach(
                $createdSoftSkillTags->shuffle()->take(rand(1, 2))->pluck('id')->toArray()
            );
        }
            
        // Create design internships (40)
        $this->command->info('Creating design internships with random states...');
        for ($i = 0; $i < 40; $i++) {
            $factory = Internship::factory()
                ->state(['employer_id' => $employerIds[array_rand($employerIds)]]);
            
            // Apply random states
            $factory = $applyRandomStates($factory);
            
            // Create the internship with applied states
            $internship = $factory->create();
            
            // Attach tags
            $internship->tags()->attach(
                $createdDesignTags->shuffle()->take(rand(2, 3))->pluck('id')->toArray()
            );
            $internship->tags()->attach(
                $createdSoftSkillTags->shuffle()->take(rand(1, 2))->pluck('id')->toArray()
            );
        }
        
        // Create business internships (15)
        $this->command->info('Creating business internships with random states...');
        for ($i = 0; $i < 15; $i++) {
            $factory = Internship::factory()
                ->state(['employer_id' => $employerIds[array_rand($employerIds)]]);
            
            // Apply random states
            $factory = $applyRandomStates($factory);
            
            // Create the internship with applied states
            $internship = $factory->create();
            
            // Attach tags
            $internship->tags()->attach(
                $createdBusinessTags->shuffle()->take(rand(2, 3))->pluck('id')->toArray()
            );
            $internship->tags()->attach(
                $createdSoftSkillTags->shuffle()->take(rand(1, 2))->pluck('id')->toArray()
            );
        }
        
        $this->command->info('Created ' . Internship::count() . ' internships with categorized tags and random states!');
    }
}