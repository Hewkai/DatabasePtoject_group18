<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Checkout | {{ config('app.name') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans antialiased">
    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-blue-600 transition mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Cart
                </a>
                <h1 class="text-2xl font-bold text-blue-600">Checkout</h1>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-600">Total Amount</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($total, 0) }} ฿</p>
            </div>
        </div>

        <div class="grid lg:grid-cols-5 gap-6">
            <!-- Left Section - Items & Shipping (3 columns) -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Cart Items by Brand -->
                @php
                    $itemsByBrand = collect($cart)->groupBy('brand');
                @endphp

                @foreach($itemsByBrand as $brand => $items)
                    <div class="bg-white rounded-2xl border border-gray-200 p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-bold text-gray-900">{{ $brand }}</h2>
                        </div>

                        <div class="space-y-4">
                            @foreach($items as $item)
                                <div class="flex gap-4">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0 w-24 h-24 bg-gray-50 rounded-xl flex items-center justify-center overflow-hidden">
                                        @php
                                            $product = \App\Models\Product::with('primaryImage')->find($item['id']);
                                            $imageUrl = $product?->primaryImage?->url;
                                        @endphp
                                        @if($imageUrl)
                                            <img src="{{ $imageUrl }}" alt="{{ $item['name'] }}" class="w-full h-full object-contain p-2">
                                        @else
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        @endif
                                    </div>

                                    <!-- Product Details -->
                                    <div class="flex-grow">
                                        <h3 class="text-base font-bold text-gray-900 mb-1">{{ $item['name'] }}</h3>
                                        <p class="text-sm font-semibold text-gray-900 mb-2">{{ number_format($item['price'], 0) }} ฿</p>
                                        
                                        <!-- Quantity Display -->
                                        <div class="flex items-center gap-3">
                                            <span class="text-sm text-gray-600">Quantity:</span>
                                            <span class="text-base font-semibold text-gray-900">{{ $item['qty'] }}</span>
                                        </div>

                                        <!-- Subtotal -->
                                        <div class="mt-2">
                                            <span class="text-sm text-gray-600">Subtotal: </span>
                                            <span class="text-base font-bold text-blue-600">{{ number_format($item['price'] * $item['qty'], 0) }} ฿</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <!-- Shipping Address -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold text-gray-900">Shipping Address</h2>
                    </div>
                    
                    @error('address')
                        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-4 flex items-start gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm">{{ $message }}</span>
                        </div>
                    @enderror

                    @php
                        $defaultAddress = '';
                        if (Auth::check() && Auth::user()->address) {
                            $defaultAddress = Auth::user()->address;
                        }
                    @endphp

                    <!-- Display Mode -->
                    <div id="addressDisplay" class="@if($errors->has('address')) hidden @endif">
                        <button type="button" onclick="toggleAddressEdit()" class="w-full text-left bg-gray-50 hover:bg-gray-100 transition rounded-xl p-4 flex items-start gap-3 group">
                            <svg class="w-6 h-6 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div class="flex-grow">
                                <p id="displayAddress" class="text-sm text-gray-900 leading-relaxed whitespace-pre-line">{{ old('address', $defaultAddress) ?: 'Click to add your shipping address' }}</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <!-- Edit Mode -->
                    <div id="addressEdit" class="@if(!$errors->has('address')) hidden @endif">
                        <div class="flex items-start gap-3 mb-4">
                            <svg class="w-6 h-6 text-gray-400 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div class="flex-grow">
                                <textarea 
                                    id="addressInput"
                                    name="address" 
                                    rows="4" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                    placeholder="e.g., House No./Street/District/City/Province/Postal Code"
                                >{{ old('address', $defaultAddress) }}</textarea>
                                @if($defaultAddress)
                                    <p class="text-xs text-gray-500 mt-2">
                                        <svg class="w-3.5 h-3.5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Using your saved address. You can edit it above for this order only.
                                    </p>
                                @endif
                            </div>
                        </div>
                        
                        <button type="button" onclick="toggleAddressEdit()" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                            Done Editing
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Section - Payment Summary (2 columns) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Summary -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Order Summary</h2>
                    
                    <div class="space-y-3 mb-6">
                        @foreach($cart as $item)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">{{ $item['brand'] }} • {{ $item['name'] }} × {{ $item['qty'] }}</span>
                                <span class="font-semibold text-gray-900">{{ number_format($item['price'] * $item['qty'], 0) }} ฿</span>
                            </div>
                        @endforeach
                        
                        <div class="border-t border-gray-200 pt-3 mt-3">
                            <div class="flex justify-between">
                                <span class="font-semibold text-gray-900">Total</span>
                                <span class="text-lg font-bold text-gray-900">{{ number_format($total, 0) }} ฿</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Available Shipping Method -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h2 class="text-base font-bold text-gray-900 mb-4">Shipping Method</h2>
                    <div class="bg-yellow-50 rounded-xl p-4 flex items-center gap-3">
                        <div class="bg-yellow-400 rounded-lg p-2 flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <h3 class="font-bold text-gray-900">Express Delivery</h3>
                            <p class="text-xs text-gray-500">Delivery in 2-3 Working days</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h2 class="text-base font-bold text-gray-900 mb-4">Payment Method</h2>
                    
                    <div class="space-y-3">
                        <div class="bg-gray-50 rounded-xl p-4 flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="flex-grow">
                                <p class="text-sm font-medium text-gray-700">Cash on Delivery</p>
                                <p class="text-xs text-gray-500">Pay when you receive</p>
                            </div>
                            <div class="w-5 h-5 border-2 border-blue-600 rounded-full flex items-center justify-center">
                                <div class="w-3 h-3 bg-blue-600 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Confirm Order Button -->
                <form method="post" action="{{ route('checkout.process') }}">
                    @csrf
                    <input type="hidden" name="address" id="hiddenAddress" value="{{ old('address', $defaultAddress) }}">
                    
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('cart.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Cart
                        </a>
                        <button type="submit" class="w-full bg-blue-600 text-white py-4 px-6 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-600/30">
                            Confirm Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-12 mt-16">
        <div class="max-w-7xl mx-auto px-8">
            <div class="text-center text-sm text-gray-500">
                <p>&copy; 2024 {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleAddressEdit() {
            const display = document.getElementById('addressDisplay');
            const edit = document.getElementById('addressEdit');
            const input = document.getElementById('addressInput');
            const displayText = document.getElementById('displayAddress');
            const hiddenInput = document.getElementById('hiddenAddress');
            
            if (display.classList.contains('hidden')) {
                // Switching back to display mode
                display.classList.remove('hidden');
                edit.classList.add('hidden');
                // Update display text with current input value
                displayText.textContent = input.value || 'Click to add your shipping address';
                // Update hidden input
                hiddenInput.value = input.value;
            } else {
                // Switching to edit mode
                display.classList.add('hidden');
                edit.classList.remove('hidden');
                input.focus();
            }
        }

        // Sync address input with hidden field on input
        document.addEventListener('DOMContentLoaded', function() {
            const addressInput = document.getElementById('addressInput');
            const hiddenAddress = document.getElementById('hiddenAddress');
            
            if (addressInput && hiddenAddress) {
                addressInput.addEventListener('input', function() {
                    hiddenAddress.value = this.value;
                });
            }
        });
    </script>
</body>
</html>