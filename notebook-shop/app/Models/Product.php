<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id','model','cpu_brand','cpu_model','ram_gb','storage_gb','gpu','price',
    ];

    // ล้าง cache ทุกครั้งที่มีการเขียนกับ products
    protected static function booted(): void
    {
        static::created(fn () => Cache::tags(['products'])->flush());
        static::updated(fn () => Cache::tags(['products'])->flush());
        static::deleted(fn () => Cache::tags(['products'])->flush());
    }

    // --- Relations ---
    public function brand()        { return $this->belongsTo(\App\Models\Brand::class); }
    public function categories()   { return $this->belongsToMany(\App\Models\Category::class); }
    public function images()       { return $this->hasMany(\App\Models\ProductImage::class); }
    public function primaryImage() { return $this->hasOne(\App\Models\ProductImage::class)->where('is_primary', 1); }
}
