<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Operator
        User::create([
            'name' => 'Operator Satu',
            'akses' => 'operator',
            'nohp' => '081234567890',
            'nohp_verified_at' => now(),
            'email' => 'operator@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12121212'),
        ]);

        // Admin
        User::create([
            'name' => 'Admin Pondok',
            'akses' => 'admin',
            'nohp' => '081223344556',
            'nohp_verified_at' => now(),
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12121212'),
        ]);

        // Wali
        User::create([
            'name' => 'Wali Santri Satu',
            'akses' => 'wali',
            'nohp' => '089876543210',
            'nohp_verified_at' => now(),
            'email' => 'wali1@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12121212'),
        ]);
    }
}
