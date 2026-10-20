<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user for testing (if not exists)
        $email = 'admin@test.com';

        $user = User::where('email', $email)->first();
        if (! $user) {
            User::create([
                'name' => 'Admin Testing',
                'email' => $email,
                'password' => bcrypt('admin123'),
            ]);
        }
    }
}
