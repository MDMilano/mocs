<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles first
        $this->call([
            RoleSeeder::class,
            DocumentSeeder::class,
        ]);

        // Create default admin account
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@mocs.test',
            'is_active' => true,
            'must_change_password' => false,
            'password' => Hash::make('password'), // Set a default password
        ]);
        $admin->assignRole('admin');

        // Create default user account
        $user = User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@mocs.test',
            'is_active' => true,
            'must_change_password' => false,
            'password' => Hash::make('password'), // Set a default password
        ]);
        $user->assignRole('user');
    }
}
