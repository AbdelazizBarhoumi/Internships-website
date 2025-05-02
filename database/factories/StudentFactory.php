<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $educationLevel = fake()->randomElement([
            'high_school', 'associate', 'bachelor', 'master', 'phd'
        ]);
        
        // Determine institutions based on education level
        $institution = match($educationLevel) {
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
        
        // Determine field of study based on education level
        $fieldOfStudy = $educationLevel === 'high_school'
            ? null
            : fake()->randomElement([
                'Computer Science', 'Information Technology', 'Software Engineering',
                'Data Science', 'Cybersecurity', 'Business Administration',
                'Marketing', 'Graphic Design', 'Psychology', 'Communications',
                'Mechanical Engineering', 'Electrical Engineering', 'Finance'
            ]);
        
        // Generate skills relevant to internships
        $skillSets = [
            'technical' => [
                'JavaScript', 'Python', 'Java', 'C++', 'PHP', 'React', 
                'Angular', 'Vue.js', 'Node.js', 'Express', 'Django', 
                'Flask', 'SQL', 'MongoDB', 'Firebase', 'AWS', 'Docker',
                'Git', 'TypeScript', 'Ruby', 'Swift', 'Kotlin'
            ],
            'design' => [
                'Photoshop', 'Illustrator', 'Figma', 'Sketch', 'InDesign',
                'UI/UX Design', 'Wireframing', 'Prototyping', 'User Research',
                'Graphic Design', 'Typography', 'Color Theory'
            ],
            'business' => [
                'Microsoft Office', 'Google Workspace', 'Social Media Marketing',
                'SEO', 'Content Writing', 'Market Research', 'Data Analysis',
                'Project Management', 'CRM Software', 'Digital Marketing'
            ],
            'soft' => [
                'Communication', 'Teamwork', 'Problem-solving', 'Critical Thinking',
                'Time Management', 'Leadership', 'Adaptability', 'Creativity'
            ]
        ];
        
        // Generate 5-10 random skills based on the field of study
        $skills = [];
        
        // Add technical skills if in a tech field
        if (in_array($fieldOfStudy, ['Computer Science', 'Information Technology', 'Software Engineering', 'Data Science', 'Cybersecurity'])) {
            $skills = array_merge($skills, fake()->randomElements($skillSets['technical'], fake()->numberBetween(3, 5)));
        }
        
        // Add design skills if in a design field
        if (in_array($fieldOfStudy, ['Graphic Design', 'Communications'])) {
            $skills = array_merge($skills, fake()->randomElements($skillSets['design'], fake()->numberBetween(2, 4)));
        }
        
        // Add business skills if in a business field
        if (in_array($fieldOfStudy, ['Business Administration', 'Marketing', 'Finance'])) {
            $skills = array_merge($skills, fake()->randomElements($skillSets['business'], fake()->numberBetween(2, 4)));
        }
        
        // Add some soft skills for everyone
        $skills = array_merge($skills, fake()->randomElements($skillSets['soft'], fake()->numberBetween(2, 4)));
        
        // Ensure we have unique skills
        $skills = array_unique($skills);
        
        // Create graduation date based on education level
        $graduationDate = match($educationLevel) {
            'high_school' => fake()->dateTimeBetween('+1 year', '+2 years'),
            'associate' => fake()->dateTimeBetween('+1 year', '+3 years'),
            'bachelor' => fake()->dateTimeBetween('+1 year', '+4 years'),
            'master' => fake()->dateTimeBetween('+1 year', '+2 years'),
            'phd' => fake()->dateTimeBetween('+1 year', '+5 years'),
        };
        
        return [
            'user_id' => User::factory(),
            'education_level' => $educationLevel,
            'institution' => $institution,
            'field_of_study' => $fieldOfStudy,
            'graduation_date' => $graduationDate,
            'skills' => implode(', ', $skills),
            'bio' => fake()->paragraphs(2, true),
            'resume_path' => fake()->boolean(70) ? 'resumes/' . fake()->uuid() . '.pdf' : null,
            'linkedin_url' => fake()->boolean(80) ? 'https://linkedin.com/in/' . fake()->userName() : null,
            'github_url' => fake()->boolean(60) ? 'https://github.com/' . fake()->userName() : null,
            'portfolio_url' => fake()->boolean(40) ? 'https://' . fake()->domainName() : null,
            'phone' => fake()->boolean(90) ? fake()->phoneNumber() : null,
        ];
    }
    
    /**
     * Configure the model factory to create a high school student.
     *
     * @return $this
     */
    public function highSchool()
    {
        return $this->state(function (array $attributes) {
            return [
                'education_level' => 'high_school',
                'institution' => fake()->randomElement([
                    'Central High School', 'Washington High School', 'Lincoln Academy', 
                    'Jefferson High School', 'Roosevelt High School'
                ]),
                'field_of_study' => null,
                'graduation_date' => fake()->dateTimeBetween('+1 year', '+2 years'),
            ];
        });
    }
    
    /**
     * Configure the model factory to create a college student.
     *
     * @return $this
     */
    public function college()
    {
        return $this->state(function (array $attributes) {
            return [
                'education_level' => fake()->randomElement(['associate', 'bachelor']),
                'graduation_date' => fake()->dateTimeBetween('+1 year', '+4 years'),
            ];
        });
    }
    
    /**
     * Configure the model factory to create a graduate student.
     *
     * @return $this
     */
    public function graduate()
    {
        return $this->state(function (array $attributes) {
            return [
                'education_level' => fake()->randomElement(['master', 'phd']),
                'graduation_date' => fake()->dateTimeBetween('+1 year', '+3 years'),
            ];
        });
    }
    
    /**
     * Configure the model factory to create a tech student.
     *
     * @return $this
     */
    public function techStudent()
    {
        return $this->state(function (array $attributes) {
            $techSkills = [
                'JavaScript', 'Python', 'Java', 'React', 'Node.js', 
                'SQL', 'Git', 'TypeScript', 'Docker', 'AWS'
            ];
            
            $selectedSkills = fake()->randomElements($techSkills, fake()->numberBetween(4, 8));
            $softSkills = ['Problem-solving', 'Teamwork', 'Communication'];
            $allSkills = array_merge($selectedSkills, $softSkills);
            
            return [
                'field_of_study' => fake()->randomElement([
                    'Computer Science', 'Information Technology', 'Software Engineering',
                    'Data Science', 'Cybersecurity'
                ]),
                'skills' => implode(', ', $allSkills),
                'github_url' => 'https://github.com/' . fake()->userName(),
            ];
        });
    }
    
    /**
     * Configure the model factory to create a business student.
     *
     * @return $this
     */
    public function businessStudent()
    {
        return $this->state(function (array $attributes) {
            $businessSkills = [
                'Microsoft Office', 'Google Workspace', 'Social Media Marketing',
                'SEO', 'Content Writing', 'Market Research', 'Data Analysis',
                'Project Management', 'CRM Software', 'Digital Marketing'
            ];
            
            $selectedSkills = fake()->randomElements($businessSkills, fake()->numberBetween(4, 8));
            $softSkills = ['Communication', 'Leadership', 'Time Management'];
            $allSkills = array_merge($selectedSkills, $softSkills);
            
            return [
                'field_of_study' => fake()->randomElement([
                    'Business Administration', 'Marketing', 'Finance',
                    'Economics', 'Accounting'
                ]),
                'skills' => implode(', ', $allSkills),
                'linkedin_url' => 'https://linkedin.com/in/' . fake()->userName(),
            ];
        });
    }
    
    /**
     * Configure the model factory to create a design student.
     *
     * @return $this
     */
    public function designStudent()
    {
        return $this->state(function (array $attributes) {
            $designSkills = [
                'Photoshop', 'Illustrator', 'Figma', 'Sketch', 'InDesign',
                'UI/UX Design', 'Wireframing', 'Prototyping', 'User Research',
                'Graphic Design', 'Typography', 'Color Theory'
            ];
            
            $selectedSkills = fake()->randomElements($designSkills, fake()->numberBetween(4, 8));
            $softSkills = ['Creativity', 'Attention to Detail', 'Communication'];
            $allSkills = array_merge($selectedSkills, $softSkills);
            
            return [
                'field_of_study' => fake()->randomElement([
                    'Graphic Design', 'Digital Media', 'Visual Communications',
                    'Interactive Design', 'Fine Arts'
                ]),
                'skills' => implode(', ', $allSkills),
                'portfolio_url' => 'https://' . fake()->domainName(),
            ];
        });
    }
}