<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // สถิติหลัก
        $totalOrders = Order::count();
        $todayOrders = Order::whereDate('created_at', today())->count();
        $totalCustomers = User::count();
        
        // Popular Brands (จากจำนวน order items)
        $popularBrands = DB::table('order_items')
            ->select('brand_name', DB::raw('SUM(quantity) as total_qty'))
            ->whereNotNull('brand_name')
            ->groupBy('brand_name')
            ->orderBy('total_qty', 'desc')
            ->limit(3)
            ->get();

        // สถานะคำสั่งซื้อ
        $orderStatusCounts = [
            'paid' => Order::where('payment_status', 'paid')->count(),
            'preparing' => Order::where('order_status', 'preparing')->count(),
            'shipped' => Order::where('order_status', 'shipped')->count(),
        ];


        // Growth rates (เปรียบเทียบกับเมื่อวาน/สัปดาห์ที่แล้ว)
        $dailyGrowth = $this->calculateDailyGrowth();
        $weeklyGrowth = $this->calculateWeeklyGrowth();

        // รายการคำสั่งซื้อล่าสุด
        $recentOrders = Order::with(['user', 'items'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'todayOrders',
            'totalCustomers',
            'popularBrands',
            'orderStatusCounts',
            'dailyGrowth',
            'weeklyGrowth',
            'recentOrders'
        ));
    }

    private function calculateDailyGrowth()
    {
        $today = Order::whereDate('created_at', today())->count();
        $yesterday = Order::whereDate('created_at', today()->subDay())->count();
        
        if ($yesterday == 0) return 0;
        return round((($today - $yesterday) / $yesterday) * 100, 1);
    }

    private function calculateWeeklyGrowth()
    {
        $thisWeek = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $lastWeek = Order::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->count();
        
        if ($lastWeek == 0) return 0;
        return round((($thisWeek - $lastWeek) / $lastWeek) * 100, 1);
    }
}