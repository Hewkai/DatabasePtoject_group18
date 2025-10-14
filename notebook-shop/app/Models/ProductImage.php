<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'url', 'is_primary', 'sort_order'];

    // แปลงชนิดอัตโนมัติ
    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer',
    ];

    // ล้าง cache ของรายการสินค้าเมื่อรูปเปลี่ยนแปลง
    protected static function booted(): void
    {
        static::created(fn () => Cache::tags(['products'])->flush());
        static::updated(fn () => Cache::tags(['products'])->flush());
        static::deleted(fn () => Cache::tags(['products'])->flush());
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
