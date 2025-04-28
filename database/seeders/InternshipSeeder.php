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
        if ($employerCount < 10) {
            $usersWithoutEmployers = User::whereDoesntHave('employer')->take(10 - $employerCount)->get();
            
            foreach ($usersWithoutEmployers as $user) {
                Employer::factory()->create(['user_id' => $user->id]);
            }
            
            // If still not enough employers, create new ones
            if (Employer::count() < 10) {
                Employer::factory(10 - Employer::count())->create();
            }
        }
        
        // Get all employer IDs
        $employerIds = Employer::pluck('id')->toArray();
        
        // Create a variety of internships
        $this->command->info('Creating regular internships...');
        
        // Create tech internships (80)
        Internship::factory(80)
            ->sequence(fn ($sequence) => ['employer_id' => $employerIds[array_rand($employerIds)]])
            ->create()
            ->each(function ($internship) use ($createdProgrammingTags, $createdSoftSkillTags) {
                // Tech internships get 2-3 programming tags + 1-2 soft skills
                $internship->tags()->attach(
                    $createdProgrammingTags->shuffle()->take(rand(2, 3))->pluck('id')->toArray()
                );
                $internship->tags()->attach(
                    $createdSoftSkillTags->shuffle()->take(rand(1, 2))->pluck('id')->toArray()
                );
            });
            
        // Create design internships (40)
        $this->command->info('Creating design internships...');
        Internship::factory(40)
            ->sequence(fn ($sequence) => ['employer_id' => $employerIds[array_rand($employerIds)]])
            ->create()
            ->each(function ($internship) use ($createdDesignTags, $createdSoftSkillTags) {
                // Design internships get 2-3 design tags + 1-2 soft skills
                $internship->tags()->attach(
                    $createdDesignTags->shuffle()->take(rand(2, 3))->pluck('id')->toArray()
                );
                $internship->tags()->attach(
                    $createdSoftSkillTags->shuffle()->take(rand(1, 2))->pluck('id')->toArray()
                );
            });
            
        // Rest of your seeder remains the same but using the created tag collections
        // instead of the factory-generated ones
        
        $this->command->info('Created ' . Internship::count() . ' internships with categorized tags!');
    }
}