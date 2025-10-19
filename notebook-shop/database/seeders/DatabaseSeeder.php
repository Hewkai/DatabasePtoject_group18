<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// เรียกใช้ seeder อื่น ๆ
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // สร้างผู้ใช้ตัวอย่าง (รันซ้ำได้ ไม่ชน unique email)
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name'              => 'Test User',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                // ผู้ใช้ตัวอย่างไม่ใช่แอดมิน
                'is_admin'          => false,
            ]
        );

        // เรียก seeder ตามลำดับ
        $this->call([
            // 1) แอดมิน (อ่านค่าจาก .env: ADMIN_NAME / ADMIN_EMAIL / ADMIN_PASSWORD)
            AdminUserSeeder::class,

            // 2) ข้อมูลอ้างอิงและสินค้า
            BrandSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}