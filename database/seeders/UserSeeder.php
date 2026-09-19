<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@uddan.com'],
            [
                'name' => 'System Admin',
                'phone' => '+91 9876543210',
                'status' => 'active',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $admin->syncRoles(['Super Admin']);

        // Telecaller 1 - Priya Sharma
        $telecaller1 = User::firstOrCreate(
            ['email' => 'telecaller1@uddan.com'],
            [
                'name' => 'Priya Sharma',
                'phone' => '+91 9876500001',
                'status' => 'active',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $telecaller1->syncRoles(['Telecaller']);

        // Telecaller 2 - Rahul Verma
        $telecaller2 = User::firstOrCreate(
            ['email' => 'telecaller2@uddan.com'],
            [
                'name' => 'Rahul Verma',
                'phone' => '+91 9876500002',
                'status' => 'active',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $telecaller2->syncRoles(['Telecaller']);

        // Telecaller 3 - Ananya Roy
        $telecaller3 = User::firstOrCreate(
            ['email' => 'telecaller3@uddan.com'],
            [
                'name' => 'Ananya Roy',
                'phone' => '+91 9876500003',
                'status' => 'active',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $telecaller3->syncRoles(['Telecaller']);
    }
}
