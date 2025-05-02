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
        // 1. Ensure Super Admin exists
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
        
        // 2. Create additional admin users if needed
        $this->createAdditionalAdmins();
    }
    
    /**
     * Create additional admin users with standard admin roles
     */
    private function createAdditionalAdmins(): void
    {
        // Check how many admins already exist
        $adminCount = Admin::count();
        
        // Create 3 additional admins if we have less than 4 total
        if ($adminCount < 4) {
            $adminEmails = [
                'moderator@internnexus.com',
                'support@internnexus.com',
                'content@internnexus.com'
            ];
            
            $adminNames = [
                'Internship Moderator',
                'Support Admin',
                'Content Manager'
            ];
            
            // Create only as many as needed to reach 9 total
            $neededAdmins = min(3, 9 - $adminCount);
            
            for ($i = 0; $i < $neededAdmins; $i++) {
                // Check if this admin email already exists
                $existingUser = User::where('email', $adminEmails[$i])->first();
                
                if (!$existingUser) {
                    // Create new user
                    $user = User::create([
                        'name' => $adminNames[$i],
                        'email' => $adminEmails[$i],
                        'password' => Hash::make('admin123'),
                        'email_verified_at' => now(),
                    ]);
                    
                    // Create admin record
                    Admin::create([
                        'user_id' => $user->id,
                        'role' => 'admin',
                    ]);
                } else {
                    // If user exists but doesn't have admin rights
                    if (!$existingUser->isAdmin()) {
                        Admin::create([
                            'user_id' => $existingUser->id,
                            'role' => 'admin',
                        ]);
                    }
                }
            }
        }
        
        // Optionally, create random admin users
        if (app()->environment('local', 'development') && $adminCount < 10) {
            // Create 5 random admin users for testing
            User::factory(10)
                ->create()
                ->each(function (User $user) {
                    Admin::create([
                        'user_id' => $user->id,
                        'role' => 'admin',
                    ]);
                });
        }
    }
}