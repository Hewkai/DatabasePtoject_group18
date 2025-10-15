<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ตะกร้าสินค้า | {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 backdrop-blur-sm bg-white/90">
        <div class="max-w-7xl mx-auto px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-10">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="flex items-center gap-3 justify-center">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                            <span class="text-white text-xl font-bold">C</span>
                        </div>
                        <span class="text-lg font-semibold">COMP</span>
                    </a>

                    <!-- Navigation -->
                    <div class="flex items-center gap-6 ml-4">
                        <a href="{{ url('/') }}" class="text-gray-900 font-medium hover:text-blue-600 transition">HOMES</a>
                        <a href="{{ url('/products') }}" class="text-gray-900 font-medium flex items-center gap-1 hover:text-blue-600 transition">
                            PRODUCTS
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="flex items-center gap-6">
                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="relative hover:opacity-80 transition">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        @php
                            $cartCount = count($cart ?? []);
                        @endphp
                        @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-blue-600 text-white text-xs {{ $cartCount > 99 ? 'min-w-[24px] px-1' : 'w-5' }} h-5 flex items-center justify-center rounded-full font-semibold">
                            {{ $cartCount > 99 ? '99+' : $cartCount }}
                        </span>
                        @endif
                    </a>

                    <!-- Orders Link -->
                    <a href="{{ route('orders.index') }}" class="text-gray-700 font-medium hover:text-blue-600 transition">
                        My Orders
                    </a>

                    <!-- User Profile / Login -->
                    @if (Route::has('login'))
                        @auth
                            <div class="relative group">
                                <button class="flex items-center gap-3 hover:opacity-80 transition">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold shadow-md overflow-hidden">
                                        @if(Auth::user()->profile_photo_path)
                                            <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <span class="font-medium text-gray-700">{{ Auth::user()->name }}</span>
                                    <svg class="w-4 h-4 text-gray-500 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                
                                <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                    <div class="py-2">
                                        <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-gray-50 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                            Dashboard
                                        </a>
                                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-gray-50 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Profile
                                        </a>
                                        <hr class="my-2 border-gray-100">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-red-600 hover:bg-red-50 transition text-left">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                ออกจากระบบ
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                เข้าสู่ระบบ
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">ตะกร้าสินค้า</h1>
        </div>

        <!-- Flash Messages -->
        @if (session('ok'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                {{ session('ok') }}
            </div>
        @endif
        @if (session('warn'))
            <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-lg">
                ⚠ {{ session('warn') }}
            </div>
        @endif

        @if (empty($cart))
            <!-- Empty Cart State -->
            <div class="flex flex-col items-center justify-center py-16">
                <div class="w-32 h-32 mb-6">
                    <svg class="w-full h-full text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">ไม่มีสินค้าในตะกร้า</h2>
                <p class="text-gray-500 mb-8">ยังไม่มีสินค้าที่เลือกอยู่ในตอนนี้</p>
                <a href="{{ url('/') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    เลือกซื้อสินค้า
                </a>
            </div>
        @else
            <!-- Cart with Items -->
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Cart Items Section -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cart as $row)
                        <div class="bg-white border border-gray-200 rounded-2xl p-6">
                            <div class="flex gap-6">
                                <!-- Product Image -->
                                <div class="flex-shrink-0 w-32 h-32 bg-gray-50 rounded-xl flex items-center justify-center">
                                    @if(isset($row['image']))
                                        <img src="{{ asset($row['image']) }}" alt="{{ $row['name'] }}" class="w-full h-full object-contain p-2">
                                    @else
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    @endif
                                </div>

                                <!-- Product Details -->
                                <div class="flex-grow">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $row['brand'] }} • {{ $row['name'] }}</h3>
                                            @if(isset($row['description']))
                                                <p class="text-sm text-gray-600 mb-3">{{ $row['description'] }}</p>
                                            @endif
                                        </div>
                                        <form method="post" action="{{ route('cart.remove', $row['id']) }}">
                                            @csrf
                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Quantity and Price -->
                                    <div class="flex justify-between items-center mt-4">
                                        <div class="flex items-center gap-3">
                                            <span class="text-gray-600">จำนวน:</span>
                                            <span class="text-lg font-semibold">{{ $row['qty'] }}</span>
                                        </div>

                                        <div class="text-right">
                                            <div class="text-xs text-gray-500 mb-1">{{ number_format($row['price'], 0) }} ฿ / ชิ้น</div>
                                            <div class="text-2xl font-bold text-gray-900">{{ number_format($row['price'] * $row['qty'], 0) }} ฿</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary Section -->
                <div class="lg:col-span-1">
                    <div class="bg-white border-2 border-gray-200 rounded-2xl p-6 sticky top-24">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">สรุปคำสั่งซื้อ</h2>

                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>ยอดรวม:</span>
                                <span class="font-semibold">{{ number_format($total, 0) }} ฿</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-900">ยอดรวมทั้งหมด:</span>
                                <span class="text-2xl font-bold text-blue-600">{{ number_format($total, 0) }} ฿</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.show') }}" class="block w-full bg-blue-600 text-white py-3.5 rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-600/30 text-center">
                            ไปชำระเงิน →
                        </a>

                        <a href="{{ url('/') }}" class="block w-full text-center mt-3 text-gray-600 hover:text-gray-900 transition">
                            ← เลือกซื้อสินค้าต่อ
                        </a>
                    </div>
                </div>
            </div>
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