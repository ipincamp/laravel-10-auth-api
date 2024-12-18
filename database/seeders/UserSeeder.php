<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // nama role
        $roleAdmin = \Spatie\Permission\Models\Role::create(['name' => 'admin']);
        \Spatie\Permission\Models\Role::create(['name' => 'customer']);

        // bikin user admin
        $userAdmin = \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@music.com',
            'password' => bcrypt('admin123'),
        ]);

        // memberikan role ke user
        $userAdmin->assignRole($roleAdmin);
    }
}
