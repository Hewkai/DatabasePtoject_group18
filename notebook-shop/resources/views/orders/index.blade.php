<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>คำสั่งซื้อของฉัน | {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .order-card {
            transition: all 0.3s ease;
        }
        .order-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8 fade-in">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">คำสั่งซื้อของฉัน</h1>
            <p class="text-gray-600">ตรวจสอบรายการคำสั่งซื้อล่าสุดของคุณ</p>
        </div>

        <!-- Flash Messages -->
        @if (session('ok'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-center gap-3 fade-in">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>{{ session('ok') }}</span>
            </div>
        @endif

        @php
            // ดึงข้อมูลจาก database
            $orders = \App\Models\Order::with(['items.product.primaryImage', 'user'])
                ->where('user_id', auth()->id())
                ->latest()
                ->paginate(10);
        @endphp

        @if ($orders->isEmpty())
            <!-- Empty Orders State -->
            <div class="flex flex-col items-center justify-center py-16 fade-in">
                <div class="w-32 h-32 mb-6 relative">
                    <svg class="w-full h-full text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <div class="absolute -top-2 -right-2 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">ยังไม่มีคำสั่งซื้อ</h2>
                <p class="text-gray-500 mb-2 text-center max-w-md">คุณยังไม่มีประวัติการสั่งซื้อ</p>
                <p class="text-sm text-gray-400 mb-8 text-center">(เดโม่นี้จะแสดงเฉพาะคำสั่งซื้อล่าสุดจาก Session หลัง Checkout)</p>
                <a href="{{ url('/products') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-600/30">
                    เริ่มช้อปปิ้ง
                </a>
            </div>
        @else
            <!-- Orders List -->
            <div class="space-y-6">
                @foreach($orders as $index => $order)
                    <div class="bg-white border-2 border-gray-200 rounded-2xl p-6 shadow-sm order-card fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                        <!-- Order Header -->
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-1">
                                    คำสั่งซื้อ #{{ $order->order_no }}
                                </h3>
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                            
                            <div class="flex gap-2">
                                <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $order->getPaymentStatusBadgeClass() }}">
                                    {{ $order->getPaymentStatusText() }}
                                </span>
                                <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $order->getStatusBadgeClass() }}">
                                    {{ $order->getStatusText() }}
                                </span>
                            </div>
                        </div>

                        <!-- Order Items Preview -->
                        <div class="border-t border-gray-200 pt-4">
                            <div class="space-y-3">
                                @foreach($order->items->take(3) as $item)
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-16 bg-gray-50 rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0">
                                            @if($item->product?->primaryImage)
                                                <img src="{{ $item->product->primaryImage->url }}" alt="{{ $item->product_name }}" class="w-full h-full object-contain p-1">
                                            @else
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="flex-grow">
                                            <p class="font-semibold text-gray-900">{{ $item->brand_name }} • {{ $item->product_name }}</p>
                                            <p class="text-sm text-gray-600">จำนวน: {{ $item->quantity }} × {{ number_format($item->price, 0) }} ฿</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-blue-600">{{ number_format($item->getSubtotal(), 0) }} ฿</p>
                                        </div>
                                    </div>
                                @endforeach
                                
                                @if($order->items->count() > 3)
                                    <p class="text-sm text-gray-500 text-center pt-2">
                                        และอีก {{ $order->items->count() - 3 }} รายการ...
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Order Footer -->
                        <div class="border-t border-gray-200 mt-4 pt-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div class="text-sm text-gray-600">
                                <p class="flex items-start gap-2">
                                    <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="line-clamp-2">{{ $order->address }}</span>
                                </p>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                <div class="text-right">
                                    <p class="text-sm text-gray-600">ยอดรวมทั้งหมด</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ number_format($order->total, 0) }} ฿</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @endif
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-12 mt-16">
        <div class="max-w-7xl mx-auto px-8">
            <div class="text-center text-sm text-gray-500">
                <p>&copy; 2024 {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>