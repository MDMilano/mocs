<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles first
        $this->call(RoleSeeder::class);

        // Create default admin account
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@mocs.test',
            'is_active' => true,
            'must_change_password' => false,
        ]);
        $admin->assignRole('admin');

        // Create default user account
        $user = User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@mocs.test',
            'is_active' => true,
            'must_change_password' => false,
        ]);
        $user->assignRole('user');
    }
}
