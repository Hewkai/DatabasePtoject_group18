<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- ยอดรวมการสั่งซื้อ -->
                <div class="bg-white p-6 rounded-2xl shadow-md">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-gray-500 text-sm">ยอดรวมการสั่งซื้อ</p>
                        <div class="bg-blue-100 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800">{{ number_format($totalOrders) }}</h2>
                    <p class="text-xs text-gray-400 mt-1">คำสั่งซื้อทั้งหมด</p>
                </div>

                <!-- ยอดรวมวันนี้ -->
                <div class="bg-white p-6 rounded-2xl shadow-md">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-gray-500 text-sm">ยอดรวมวันนี้</p>
                        <div class="bg-green-100 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800">{{ number_format($todayOrders) }}</h2>
                    <p class="text-xs text-gray-400 mt-1">คำสั่งซื้อวันนี้</p>
                </div>

                <!-- ชำระเงินแล้ว -->
                <div class="bg-white p-6 rounded-2xl shadow-md">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-gray-500 text-sm">ชำระเงินแล้ว</p>
                        <div class="bg-purple-100 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800">{{ number_format($orderStatusCounts['paid']) }}</h2>
                    <p class="text-xs text-gray-400 mt-1">ออเดอร์ที่ชำระแล้ว</p>
                </div>

                <!-- จัดส่งแล้ว -->
                <div class="bg-white p-6 rounded-2xl shadow-md">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-gray-500 text-sm">จัดส่งแล้ว</p>
                        <div class="bg-yellow-100 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800">{{ number_format($orderStatusCounts['shipped']) }}</h2>
                    <p class="text-xs text-gray-400 mt-1">ออเดอร์จัดส่งแล้ว</p>
                </div>
            </div>

            <!-- Customer Overview (Chart) -->
            <div class="bg-white rounded-2xl shadow-md p-8 flex flex-col lg:flex-row justify-between items-center gap-10">
                <!-- Donut Chart + Total -->
                <div class="flex flex-col items-center w-full lg:w-1/3">
                    <div class="relative w-48 h-48">
                        <svg class="w-full h-full transform -rotate-90">
                            <circle cx="96" cy="96" r="80" stroke="#f0f0f0" stroke-width="16" fill="none"/>
                            <circle cx="96" cy="96" r="80" stroke="url(#gradient)" stroke-width="16" stroke-linecap="round"
                                stroke-dasharray="510" stroke-dashoffset="90" fill="none"/>
                            <defs>
                                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#60a5fa"/>
                                    <stop offset="100%" stop-color="#86efac"/>
                                </linearGradient>
                            </defs>
                        </svg>
                        <div class="absolute inset-0 flex flex-col justify-center items-center">
                            <span class="text-3xl font-bold text-gray-800">{{ $totalCustomers }}</span>
                            <span class="text-gray-500 text-sm">Total</span>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-700 font-semibold text-lg">จำนวนลูกค้า <span class="text-2xl font-bold">{{ number_format($totalCustomers) }}</span> คน</p>
                </div>

                <!-- Growth Stats -->
                <div class="flex flex-col justify-center space-y-6 text-gray-600 w-full lg:w-1/3">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 flex justify-center items-center rounded-full bg-indigo-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xl font-semibold {{ $dailyGrowth >= 0 ? 'text-indigo-600' : 'text-red-600' }}">
                                {{ $dailyGrowth >= 0 ? '+' : '' }}{{ $dailyGrowth }}%
                            </p>
                            <p class="text-sm text-gray-500">Daily Growth</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 flex justify-center items-center rounded-full bg-green-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xl font-semibold {{ $weeklyGrowth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $weeklyGrowth >= 0 ? '+' : '' }}{{ $weeklyGrowth }}%
                            </p>
                            <p class="text-sm text-gray-500">Weekly Growth</p>
                        </div>
                    </div>
                </div>

                <!-- Popular Brands -->
                <div class="flex flex-col space-y-4 text-gray-600 w-full lg:w-1/3">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">🏆 Top Brands</h3>
                    @forelse($popularBrands as $index => $brand)
                        <div class="flex items-center justify-between border-b pb-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 flex items-center justify-center rounded-full 
                                    {{ $index === 0 ? 'bg-yellow-100 text-yellow-600' : ($index === 1 ? 'bg-gray-100 text-gray-600' : 'bg-orange-100 text-orange-600') }} 
                                    font-bold text-sm">
                                    {{ $index + 1 }}
                                </div>
                                <span class="text-gray-700 font-medium">{{ $brand->brand_name }}</span>
                            </div>
                            <span class="text-gray-800 font-bold text-lg">{{ number_format($brand->total_qty) }} ชิ้น</span>
                        </div>
                    @empty
                        <div class="text-center py-4 text-gray-400">
                            <p class="text-sm">ยังไม่มีข้อมูลแบรนด์ยอดนิยม</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Orders Table Section -->
            <div class="bg-white p-8 rounded-2xl shadow-md">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                    <h2 class="text-lg font-semibold text-gray-700">ตารางคำสั่งซื้อล่าสุด</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-gray-400 border-b">
                                <th class="pb-3 text-left">รหัสคำสั่งซื้อ</th>
                                <th class="pb-3 text-left">รายการสินค้า</th>
                                <th class="pb-3 text-left">วันที่</th>
                                <th class="pb-3 text-left">ชื่อ</th>
                                <th class="pb-3 text-left">การชำระเงิน</th>
                                <th class="pb-3 text-left">สถานะ</th>
                                <th class="pb-3 text-right">ราคา</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="py-3 font-mono text-xs">{{ $order->order_no }}</td>
                                    <td class="max-w-md">
                                        <div class="flex items-center gap-2">
                                            @php
                                                $itemsList = $order->items->map(function($item) {
                                                    return ($item->brand_name ? $item->brand_name . ' ' : '') . $item->product_name . ' x' . $item->quantity;
                                                })->implode(', ');
                                            @endphp
                                            <span class="truncate" title="{{ $itemsList }}">{{ $itemsList ?: 'N/A' }}</span>
                                            @if($order->items->count() > 1)
                                                <span class="flex-shrink-0 inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-blue-500 rounded-full">
                                                    {{ $order->items->count() }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $order->user->name ?? 'ไม่ระบุ' }}</td>

                                    <td>
                                        <span class="px-3 py-1 rounded-full text-xs 
                                            @if($order->payment_status === 'paid') bg-green-100 text-green-600
                                            @elseif($order->payment_status === 'cancelled') bg-red-100 text-red-600
                                            @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-600
                                            @endif">
                                            {{ $order->getPaymentStatusText() }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="px-3 py-1 rounded-full text-xs 
                                            @if($order->order_status === 'preparing') bg-yellow-100 text-yellow-700
                                            @elseif($order->order_status === 'delivered') bg-green-100 text-green-700
                                            @elseif($order->order_status === 'shipped') bg-blue-100 text-blue-700
                                            @elseif($order->order_status === 'cancelled') bg-red-100 text-red-700
                                            @endif">
                                            {{ $order->getStatusText() }}
                                        </span>
                                    </td>

                                    <td class="text-right font-semibold">{{ number_format($order->total, 0) }} ฿</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="text-lg font-semibold">ไม่พบคำสั่งซื้อ</p>
                                            <p class="text-sm">ยังไม่มีคำสั่งซื้อในระบบ</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Simple Info -->
                @if($recentOrders->isNotEmpty())
                    <div class="mt-6 text-sm text-gray-500 text-center">
                        แสดง {{ $recentOrders->count() }} รายการล่าสุด
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>