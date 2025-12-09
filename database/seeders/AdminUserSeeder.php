<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Upsert admin user with required non-null columns
        $existing = DB::table('users')->where('username', 'admin')->first();
        if (!$existing) {
            DB::table('users')->insert([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        } else {
            DB::table('users')->where('id', $existing->id)->update([
                'password' => Hash::make('admin123'),
                'updated_at' => $now,
            ]);
        }
    }
}