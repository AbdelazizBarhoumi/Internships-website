<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the admin user already exists
        $adminUser = User::where('email', 'abdulazeezbrhomi@gmail.com')->first();

        if (!$adminUser) {
            // Create admin user
            $adminUser = User::create([
                'name' => 'Admin',
                'email' => 'abdulazeezbrhomi@gmail.com',
                'password' => Hash::make('admin123'), // Change this immediately in production!
            ]);
        }

        // Check if user already has admin privileges
        if (!$adminUser->isAdmin()) {
            // Create admin record
            Admin::create([
                'user_id' => $adminUser->id,
                'role' => 'super_admin',
            ]);
        }
    }
}