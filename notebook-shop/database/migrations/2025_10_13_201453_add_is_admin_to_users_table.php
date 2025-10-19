<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add is_admin column to users table (idempotent).
     */
    public function up(): void
    {
        // เพิ่มคอลัมน์ก็ต่อเมื่อยังไม่มี
        if (!Schema::hasColumn('users', 'is_admin')) {
            Schema::table('users', function (Blueprint $table) {
                // ใช้ default(false) และ not null
                $table->boolean('is_admin')
                    ->default(false)
                    ->after('email_verified_at')
                    ->comment('Mark user as admin');
            });
        }
    }

    /**
     * Drop is_admin column (safe).
     */
    public function down(): void
    {
        // ลบคอลัมน์ก็ต่อเมื่อมีอยู่จริง
        if (Schema::hasColumn('users', 'is_admin')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('is_admin');
            });
        }
    }
};
