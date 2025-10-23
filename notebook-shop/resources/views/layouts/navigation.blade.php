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
                <div class="flex items-center gap-8 ml-4">
                    <a href="{{ url('/') }}" 
                       class="font-medium hover:text-blue-600 transition {{ request()->is('/') ? 'text-blue-600' : 'text-gray-900' }}">
                        HOMES
                    </a>
                    
                    <!-- Products with Dropdown -->
                    <div class="relative group">
                        <a href="{{ url('/products') }}" 
                           class="font-medium flex items-center gap-1 hover:text-blue-600 transition {{ request()->is('products*') ? 'text-blue-600' : 'text-gray-900' }}">
                            PRODUCTS
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute left-0 mt-2 w-64 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 max-h-96 overflow-y-auto">
                            <div class="py-2">
                                <!-- All Products -->
                                <a href="{{ url('/products') }}" 
                                   class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                    All Products
                                </a>
                                
                                <hr class="my-2 border-gray-100">
                                
                                <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Brands
                                </div>
                                
                                <!-- Dynamic Brands List -->
                                @php
                                    $brands = \App\Models\Brand::orderBy('name', 'asc')->get();
                                @endphp
                                
                                @foreach($brands as $brand)
                                    <a href="{{ url('/products?brand=' . urlencode($brand->name)) }}" 
                                       class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        {{ $brand->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        
                    </div>
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
                        $cart = session('cart', []);
                        $cartCount = array_sum(array_column($cart, 'qty'));
                    @endphp
                    @if($cartCount > 0)
                    <span class="absolute -top-2 -right-2 bg-blue-600 text-white text-xs {{ $cartCount > 99 ? 'min-w-[24px] px-1' : 'w-5' }} h-5 flex items-center justify-center rounded-full font-semibold">
                        {{ $cartCount > 99 ? '99+' : $cartCount }}
                    </span>
                    @endif
                </a>

                <!-- User Profile / Login Button -->
                @if (Route::has('login'))
                    @auth
                        <!-- Profile Dropdown -->
                        <div class="relative group">
                            <button class="flex items-center gap-3 hover:opacity-80 transition">
                                <!-- Profile Image -->
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold shadow-md overflow-hidden">
                                    <img src="{{ Auth::user()->avatarUrl() }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                </div>
                                <!-- Name -->
                                <span class="font-medium text-gray-700">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-500 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="py-2">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-gray-50 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profile
                                    </a>
                                    
                                    <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-gray-50 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                        My Orders
                                    </a>
                                    
                                    @if (auth()->user()->is_admin)
                                        <hr class="my-2 border-gray-100">
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-gray-50 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Admin Dashboard
                                        </a>
                                        <a href="{{ url('/members') }}" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-gray-50 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            Members
                                        </a>
                                        <a href="/api/products" target="_blank" rel="noopener" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-gray-50 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                            </svg>
                                            API Products
                                        </a>
                                    @endif
                                    
                                    <hr class="my-2 border-gray-100">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-red-600 hover:bg-red-50 transition text-left">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Logout
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
                            Login
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </div>

    <!-- Custom Scrollbar Style for Dropdown -->
    <style>
        .group:hover .group-hover\:opacity-100 {
            animation: slideDown 0.2s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Custom Scrollbar */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</nav>