<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // ต้องมีคอลัมน์ is_admin ก่อน
        if (! Schema::hasColumn('users', 'is_admin')) {
            $this->command?->warn('Skip AdminUserSeeder: users.is_admin not found. Run migration first.');
            return;
        }

        $email    = env('ADMIN_EMAIL', 'admin@example.com');
        $password = env('ADMIN_PASSWORD', 'password');
        $name     = env('ADMIN_NAME', 'Admin');

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name'              => $name,
                'password'          => Hash::make($password),
                'email_verified_at' => now(),
                'remember_token'    => Str::random(20),
            ]
        );

        $user->is_admin = true;
        $user->save();

        $this->command?->info("Admin user ready: {$email} / (password from .env: ADMIN_PASSWORD)");
    }
}
