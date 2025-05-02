<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'first_name' => 'Dev',
            'last_name' => 'Admin',
            'email' => 'admin@devtest.com',
            'password' => bcrypt('Qwerty1!'),
            'role' => 'admin',
        ]);

        $admin->admin()->create([
            'phone' => '1234567890',
            'photo' => 'https://example.com/photo.jpg',
        ]);
    }
}
