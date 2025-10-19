<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

// เรียก seeder อื่น ๆ
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // กันพังกรณียังไม่ได้ migrate
        if (Schema::hasTable('users')) {
            // ผู้ใช้ทดสอบ (idempotent)
            User::updateOrCreate(
                ['email' => 'test@example.com'],
                [
                    'name' => 'Test User',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
        }

        // เรียก seeder ตามลำดับ (idempotent)
        $this->call([
            AdminUserSeeder::class, // ← สร้างแอดมินจาก .env: ADMIN_EMAIL/ADMIN_PASSWORD/ADMIN_NAME
            BrandSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
