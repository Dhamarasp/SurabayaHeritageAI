<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@surabayaai.com',
            'password' => Hash::make('password123'),
        ]);

        // Assign admin role
        $adminRole = Role::where('slug', 'admin')->first();
        $admin->roles()->attach($adminRole);
    }
}
