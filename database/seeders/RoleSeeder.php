<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Admin',
                'slug' => 'administrator',
                'description' => 'Dapat Mengelola Data Web'
            ],
            [
                'name' => 'User',
                'slug' => 'user',
                'description' => 'User Biasa'
            ]
        ];

        foreach ($data as $role){
            Role::create($role);
        }
    }
}
