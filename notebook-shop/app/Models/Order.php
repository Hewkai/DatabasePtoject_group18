<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_no',
        'user_id',
        'total',
        'address',
        'payment_status',
        'order_status',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'total' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Helper methods
    public function getStatusBadgeClass()
    {
        return match($this->order_status) {
            'preparing' => 'bg-yellow-100 text-yellow-700',
            'shipped' => 'bg-blue-100 text-blue-700',
            'delivered' => 'bg-green-100 text-green-700',
            'cancelled' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    public function getStatusText()
    {
        return match($this->order_status) {
            'preparing' => 'เตรียมพัสดุ',
            'shipped' => 'จัดส่งแล้ว',
            'delivered' => 'จัดส่งสำเร็จ',
            'cancelled' => 'ยกเลิก',
            default => 'ไม่ทราบสถานะ',
        };
    }

    public function getPaymentStatusBadgeClass()
    {
        return match($this->payment_status) {
            'paid' => 'bg-green-100 text-green-600',
            'pending' => 'bg-yellow-100 text-yellow-600',
            'cancelled' => 'bg-red-100 text-red-600',
            default => 'bg-gray-100 text-gray-600',
        };
    }

    public function getPaymentStatusText()
    {
        return match($this->payment_status) {
            'paid' => 'ชำระเงินสำเร็จ',
            'pending' => 'รอชำระเงิน',
            'cancelled' => 'ยกเลิกชำระเงิน',
            default => 'ไม่ทราบสถานะ',
        };
    }
}