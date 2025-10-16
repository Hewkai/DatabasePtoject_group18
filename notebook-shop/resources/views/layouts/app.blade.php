<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Notebook Shop') }}</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- เพิ่มสไตล์เล็กน้อยสำหรับ dropdown hover --}}
    <style>
        .group:hover .group-hover\:opacity-100 {
            opacity: 1;
        }
        .group:hover .group-hover\:visible {
            visibility: visible;
        }
        .group:hover .group-hover\:rotate-180 {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        {{-- Navigation Bar --}}
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

                        <!-- Navigation Links -->
                        <div class="flex items-center gap-8 ml-4">
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
                                $cartCount = session()->has('cart') ? count(session('cart')) : 0;
                            @endphp
                            @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-blue-600 text-white text-xs {{ $cartCount > 99 ? 'min-w-[24px] px-1' : 'w-5' }} h-5 flex items-center justify-center rounded-full font-semibold">
                                {{ $cartCount > 99 ? '99+' : $cartCount }}
                            </span>
                            @endif
                        </a>

                        <!-- Orders Link -->
                        @auth
                        <a href="{{ route('orders.index') }}" class="text-gray-700 font-medium hover:text-blue-600 transition">
                            My Orders
                        </a>
                        @endauth

                        <!-- Admin Links (if admin) -->
                        @auth
                            @if(auth()->user()->is_admin)
                                <a href="/admin" class="text-gray-700 font-medium hover:text-blue-600 transition">Admin</a>
                                <a href="/api/products" target="_blank" rel="noopener" class="text-gray-700 font-medium hover:text-blue-600 transition">API</a>
                            @endif
                        @endauth

                        <!-- User Profile / Login -->
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
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-8 py-8">
                {{-- รองรับทั้งแบบ Component ($slot) และแบบ Layout (@section/@yield) --}}
                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </div>
        </main>
    </div>
</body>
</html>