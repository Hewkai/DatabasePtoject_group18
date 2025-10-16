<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shopping Cart | {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Shopping Cart</h1>
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
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Your cart is empty</h2>
                <p class="text-gray-500 mb-8">You haven't added any items yet</p>
                <a href="{{ url('/products') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Browse Products
                </a>
            </div>
        @else
            <!-- Cart with Items -->
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Cart Items Section -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cart as $row)
                        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                            <div class="flex gap-6">
                                <!-- Product Image -->
                                <div class="flex-shrink-0 w-32 h-32 bg-gray-50 rounded-xl flex items-center justify-center overflow-hidden">
                                    @php
                                        $product = \App\Models\Product::with('primaryImage')->find($row['id']);
                                        $imageUrl = $product?->primaryImage?->url;
                                    @endphp
                                    @if($imageUrl)
                                        <img src="{{ $imageUrl }}" alt="{{ $row['name'] }}" class="w-full h-full object-contain p-2">
                                    @else
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    @endif
                                </div>

                                <!-- Product Details -->
                                <div class="flex-grow">
                                    <!-- Product Title and Remove Button -->
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex-grow pr-4">
                                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $row['brand'] }} {{ $row['name'] }}</h3>
                                            <p class="text-sm text-gray-600">
                                                @if(isset($row['cpu_brand']) && isset($row['cpu_model']))
                                                    {{ $row['cpu_brand'] }} {{ $row['cpu_model'] }}
                                                @endif
                                                @if(isset($row['ram_gb']))
                                                    • {{ $row['ram_gb'] }}GB RAM
                                                @endif
                                                @if(isset($row['storage_gb']))
                                                    • {{ $row['storage_gb'] }}GB Storage
                                                @endif
                                                @if(isset($row['gpu']))
                                                    <br>{{ $row['gpu'] }}
                                                @endif
                                            </p>
                                        </div>
                                        <form method="post" action="{{ route('cart.remove', $row['id']) }}">
                                            @csrf
                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition p-1">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Price and Quantity Controls -->
                                    <div class="flex justify-between items-center mt-6">
                                        <!-- Price -->
                                        <div class="text-left">
                                            <div class="text-2xl font-bold text-gray-900">${{ number_format($row['price'], 2) }}</div>
                                            <div class="text-xs text-green-600 flex items-center mt-1">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                In stock
                                            </div>
                                        </div>

                                        <!-- Quantity Controls -->
                                        <div class="flex items-center gap-3 bg-gray-100 rounded-lg p-1">
                                            <form method="post" action="{{ route('cart.decrease', $row['id']) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="w-8 h-8 flex items-center justify-center text-gray-600 hover:text-gray-900 hover:bg-white rounded transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                    </svg>
                                                </button>
                                            </form>
                                            
                                            <span class="text-lg font-semibold text-gray-900 w-8 text-center">{{ $row['qty'] }}</span>
                                            
                                            <form method="post" action="{{ route('cart.increase', $row['id']) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="w-8 h-8 flex items-center justify-center text-gray-600 hover:text-gray-900 hover:bg-white rounded transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary Section -->
                <div class="lg:col-span-1">
                    <div class="bg-white border-2 border-gray-200 rounded-2xl p-6 sticky top-24 shadow-sm">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h2>

                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal:</span>
                                <span class="font-semibold">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-900">Total:</span>
                                <span class="text-2xl font-bold text-blue-600">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.show') }}" class="block w-full bg-blue-600 text-white py-3.5 rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-600/30 text-center">
                            Proceed to Checkout →
                        </a>

                        <a href="{{ url('/products') }}" class="block w-full text-center mt-3 text-gray-600 hover:text-gray-900 transition">
                            ← Continue Shopping
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