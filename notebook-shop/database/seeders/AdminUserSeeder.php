<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $name  = env('ADMIN_NAME', 'Admin');
        $email = env('ADMIN_EMAIL', 'admin@example.com');
        $pass  = env('ADMIN_PASSWORD', 'password');

        // สร้าง/อัปเดตผู้ใช้แอดมินตามอีเมล
        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name'     => $name,
                'password' => Hash::make($pass),
                'is_admin' => true,
            ]
        );

        // เผื่อฐานข้อมูลมี user เดิม ให้บังคับ is_admin = true
        if (!$user->is_admin) {
            $user->is_admin = true;
            $user->save();
        }
    }
}