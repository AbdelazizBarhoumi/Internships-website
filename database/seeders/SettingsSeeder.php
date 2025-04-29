<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'site_name',
                'value' => json_encode(config('app.name')),
                'description' => 'The name of the website',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'registration_open',
                'value' => json_encode(true),
                'description' => 'Allow new users to register',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'employer_approval_required',
                'value' => json_encode(true),
                'description' => 'Require admin approval for employer accounts',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'max_internships_per_employer',
                'value' => json_encode(10),
                'description' => 'Maximum number of internships an employer can post',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'max_applications_per_user',
                'value' => json_encode(5),
                'description' => 'Maximum number of applications a user can submit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}