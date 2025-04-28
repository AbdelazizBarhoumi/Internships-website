<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Skills and requirements commonly found in internship listings.
     */
    protected $skillCategories = [
        'programming' => [
            'JavaScript', 'Python', 'Java', 'PHP', 'C#', 'C++', 'TypeScript',
            'Ruby', 'Go', 'Kotlin', 'Swift', 'R', 'MATLAB', 'Scala', 'Rust',
            'React', 'Angular', 'Vue.js', 'Node.js', 'Express.js', 'Django', 
            'Laravel', 'Spring Boot', 'Flask', 'ASP.NET', 'Ruby on Rails',
            'SQL', 'MongoDB', 'PostgreSQL', 'MySQL', 'AWS', 'Azure', 'GCP',
            'Docker', 'Kubernetes', 'Git', 'GitHub', 'CI/CD', 'DevOps'
        ],
        'design' => [
            'UI/UX Design', 'Graphic Design', 'Visual Design', 'Web Design',
            'Adobe Photoshop', 'Adobe Illustrator', 'Adobe XD', 'Figma', 'Sketch',
            'InDesign', 'After Effects', 'Premiere Pro', 'Blender', 'Maya', '3D Modeling',
            'Animation', 'Motion Graphics', 'Typography', 'Color Theory', 'Wireframing',
            'Prototyping', 'User Research', 'Responsive Design', 'Accessibility'
        ],
        'business' => [
            'Marketing', 'Digital Marketing', 'Content Marketing', 'SEO', 'SEM', 
            'Social Media Marketing', 'Email Marketing', 'Market Research', 'Sales',
            'Business Development', 'Customer Service', 'Public Relations', 'CRM',
            'Data Analysis', 'Google Analytics', 'Excel', 'PowerPoint', 'Tableau',
            'Power BI', 'Financial Analysis', 'Accounting', 'Project Management',
            'Agile', 'Scrum', 'Event Planning', 'Operations'
        ],
        'softSkills' => [
            'Communication', 'Teamwork', 'Problem Solving', 'Critical Thinking',
            'Time Management', 'Organization', 'Leadership', 'Creativity',
            'Adaptability', 'Work Ethic', 'Attention to Detail', 'Interpersonal Skills',
            'Customer Focus', 'Presentation Skills', 'Written Communication',
            'Verbal Communication', 'Analytical Thinking', 'Research'
        ]
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Flatten array of all skills
        $allSkills = array_merge(...array_values($this->skillCategories));
        
        return [
            'name' => fake()->unique()->randomElement($allSkills),
        ];
    }
    
    /**
     * Create a programming-related tag.
     */
    public function programming()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => fake()->unique()->randomElement($this->skillCategories['programming']),
            ];
        });
    }
    
    /**
     * Create a design-related tag.
     */
    public function design()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => fake()->unique()->randomElement($this->skillCategories['design']),
            ];
        });
    }
    
    /**
     * Create a business-related tag.
     */
    public function business()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => fake()->unique()->randomElement($this->skillCategories['business']),
            ];
        });
    }
    
    /**
     * Create a soft skill tag.
     */
    public function softSkill()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => fake()->unique()->randomElement($this->skillCategories['softSkills']),
            ];
        });
    }
}