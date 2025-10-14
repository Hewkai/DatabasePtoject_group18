<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Sanctum
use Laravel\Sanctum\HasApiTokens;

// Filament
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * ฟิลด์ที่อนุญาตให้กรอก/อัปเดตได้
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',

        // ฟิลด์โปรไฟล์เพิ่มเติม
        'phone',
        'address',
        'avatar_path',
    ];

    /**
     * ฟิลด์ที่ซ่อนไม่ให้ serialize ออกไป
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * casting ของฟิลด์
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * ให้เข้าแผง Filament ได้เฉพาะผู้ใช้ที่เป็นแอดมิน
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return (bool) $this->is_admin;
    }

    /**
     * Accessor: URL ของรูปโปรไฟล์
     * - ถ้ามีไฟล์ที่อัปโหลดไว้ใน storage ให้ใช้ไฟล์นั้น
     * - ถ้าไม่มี ให้ใช้ภาพ avatar ชั่วคราวจาก ui-avatars
     */
    public function avatarUrl(): string
    {
        if ($this->avatar_path) {
            return asset('storage/' . ltrim($this->avatar_path, '/'));
        }
        // รูปเริ่มต้นเรียบง่าย (สามารถเปลี่ยนเป็นไฟล์จริงได้)
        $initial = urlencode(mb_substr($this->name ?? 'U', 0, 1));
        return "https://dummyimage.com/160x160/e5e7eb/111&text={$initial}";
    }
}
