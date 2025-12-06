<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@smartsalon.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'phone' => '1234567890',
        ]);

        // Create Customer User
        User::create([
            'name' => 'Customer User',
            'email' => 'user@smartsalon.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'phone' => '0987654321',
        ]);

        // Create Services
        \App\Models\Service::create([
            'title' => 'Men\'s Haircut',
            'description' => 'A stylish haircut for men including wash and styling.',
            'price' => 25.00,
            'duration_minutes' => 30,
        ]);

        \App\Models\Service::create([
            'title' => 'Women\'s Haircut',
            'description' => 'Professional haircut and styling for women.',
            'price' => 45.00,
            'duration_minutes' => 60,
        ]);

        \App\Models\Service::create([
            'title' => 'Manicure',
            'description' => 'Complete hand nail care treatment.',
            'price' => 20.00,
            'duration_minutes' => 45,
        ]);

        // Create Staff
        \App\Models\Staff::create([
            'name' => 'John Doe',
            'specialization' => 'Senior Stylist',
            'bio' => 'Expert in men\'s grooming with 10 years experience.',
            'is_active' => true,
        ]);

        \App\Models\Staff::create([
            'name' => 'Jane Smith',
            'specialization' => 'Colorist',
            'bio' => 'Certified color expert specializing in balayage.',
            'is_active' => true,
        ]);
    }
}
