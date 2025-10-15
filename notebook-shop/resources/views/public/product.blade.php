<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $product->brand?->name }} {{ $product->model }} - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .image-gallery {
            transition: all 0.3s ease;
        }

        .thumbnail {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .thumbnail:hover {
            transform: scale(1.05);
            border-color: #2563eb;
        }

        .thumbnail.active {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px #2563eb;
        }

        .spec-card {
            transition: all 0.3s ease;
        }

        .spec-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
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

        .zoom-image {
            transition: transform 0.3s ease;
        }

        .zoom-image:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Breadcrumb -->
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center gap-2 text-sm">
                <a href="{{ url('/') }}" class="text-gray-500 hover:text-blue-600 transition">Home</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ url('/products') }}" class="text-gray-500 hover:text-blue-600 transition">Products</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-900 font-medium">{{ $product->brand?->name }} {{ $product->model }}</span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Left Column - Images -->
            <div class="space-y-4 fade-in">
                <!-- Main Image -->
                <div class="bg-white rounded-2xl p-8 shadow-sm">
                    <div class="aspect-video bg-gray-50 rounded-xl overflow-hidden flex items-center justify-center">
                        @if($product->primaryImage?->url)
                            <img 
                                id="main-image" 
                                src="{{ $product->primaryImage->url }}" 
                                alt="{{ $product->brand?->name }} {{ $product->model }}" 
                                class="w-full h-full object-contain zoom-image"
                            >
                        @else
                            <div class="text-center text-gray-400">
                                <svg class="w-24 h-24 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <p class="text-lg">No Image Available</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Thumbnail Gallery -->
                @if($product->images && $product->images->count() > 1)
                <div class="grid grid-cols-4 gap-3">
                    @foreach($product->images as $index => $image)
                        <div 
                            class="thumbnail aspect-video bg-white rounded-lg overflow-hidden border-2 {{ $index === 0 ? 'active border-blue-600' : 'border-gray-200' }}"
                            onclick="changeMainImage('{{ $image->url }}', this)"
                        >
                            <img 
                                src="{{ $image->url }}" 
                                alt="Image {{ $index + 1 }}" 
                                class="w-full h-full object-contain p-2"
                            >
                        </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Right Column - Product Info -->
            <div class="space-y-6 fade-in">
                <!-- Product Title & Brand -->
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        @if($product->brand)
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                                {{ $product->brand->name }}
                            </span>
                        @endif
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            In Stock
                        </span>
                    </div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-3">
                        {{ $product->model }}
                    </h1>
                    
                    <!-- Rating (Mock) -->
                    <div class="flex items-center gap-3">
                        <div class="flex gap-1">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5 {{ $i < 4 ? 'text-yellow-400' : 'text-gray-300' }} fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-gray-600 text-sm">(4.0 / 128 reviews)</span>
                    </div>
                </div>

                <!-- Price -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 border border-blue-200">
                    <div class="flex items-end gap-3">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Price</p>
                            <p class="text-4xl font-bold text-blue-600">
                                @php 
                                    $price = $product->price ? (float) $product->price : 0;
                                @endphp
                                {{ $price ? number_format($price, 0) : '-' }} 
                                <span class="text-2xl">฿</span>
                            </p>
                        </div>
                        @if($price > 0)
                        <div class="text-sm text-gray-600">
                            <p>or ฿{{ number_format($price / 12, 0) }}/month</p>
                            <p class="text-xs">for 12 months</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    @auth
                        <form method="POST" action="{{ route('cart.add') }}" class="flex-1">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button 
                                type="submit" 
                                class="w-full px-6 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition flex items-center justify-center gap-2 shadow-lg shadow-blue-600/30"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                Add to Cart
                            </button>
                        </form>
                        <button class="px-6 py-4 bg-white border-2 border-gray-200 hover:border-red-300 hover:bg-red-50 rounded-xl transition flex items-center justify-center group">
                            <svg class="w-6 h-6 text-gray-400 group-hover:text-red-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    @else
                        <a 
                            href="{{ route('login') }}" 
                            class="flex-1 px-6 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition flex items-center justify-center gap-2 shadow-lg shadow-blue-600/30"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Login to Purchase
                        </a>
                    @endauth
                </div>

                <!-- Quick Info -->
                <div class="bg-white rounded-2xl p-6 shadow-sm space-y-4">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Quick Info
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-3 text-gray-600">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Free delivery on orders over ฿2,000</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-600">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>1 Year Warranty Included</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-600">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>7 Days Return Policy</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-600">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Genuine Product Guarantee</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Specifications Section -->
        <div class="mt-12 bg-white rounded-2xl p-8 shadow-sm fade-in">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Technical Specifications
            </h2>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- CPU Card -->
                <div class="spec-card bg-gradient-to-br from-blue-50 to-white rounded-xl p-5 border border-blue-100">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">Processor</h3>
                    </div>
                    <p class="text-sm text-gray-600">
                        {{ trim(($product->cpu_brand.' '.$product->cpu_model)) ?: 'Not specified' }}
                    </p>
                </div>

                <!-- RAM Card -->
                <div class="spec-card bg-gradient-to-br from-purple-50 to-white rounded-xl p-5 border border-purple-100">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">Memory</h3>
                    </div>
                    <p class="text-sm text-gray-600">
                        {{ $product->ram_gb ? $product->ram_gb.' GB RAM' : 'Not specified' }}
                    </p>
                </div>

                <!-- Storage Card -->
                <div class="spec-card bg-gradient-to-br from-green-50 to-white rounded-xl p-5 border border-green-100">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">Storage</h3>
                    </div>
                    <p class="text-sm text-gray-600">
                        {{ $product->storage_gb ? $product->storage_gb.' GB SSD' : 'Not specified' }}
                    </p>
                </div>

                <!-- GPU Card -->
                <div class="spec-card bg-gradient-to-br from-orange-50 to-white rounded-xl p-5 border border-orange-100">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">Graphics</h3>
                    </div>
                    <p class="text-sm text-gray-600">
                        {{ $product->gpu ?: 'Not specified' }}
                    </p>
                </div>
            </div>

            <!-- Additional Specs Table -->
            @if($product->categories && $product->categories->count() > 0)
            <div class="mt-8 border-t border-gray-200 pt-6">
                <h3 class="font-semibold text-gray-900 mb-4">Categories</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($product->categories as $category)
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                            {{ $category->name }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Back to Products Button -->
        <div class="mt-8 text-center">
            <a 
                href="{{ url('/products') }}" 
                class="inline-flex items-center gap-2 px-6 py-3 bg-white border-2 border-gray-200 hover:border-blue-600 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium rounded-xl transition"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Browse More Products
            </a>
        </div>
    </div>

    <!-- Footer Spacer -->
    <div class="h-20"></div>

    <script>
        // Change main image when clicking thumbnail
        function changeMainImage(imageUrl, element) {
            const mainImage = document.getElementById('main-image');
            if (mainImage) {
                mainImage.src = imageUrl;
                
                // Update active thumbnail
                document.querySelectorAll('.thumbnail').forEach(thumb => {
                    thumb.classList.remove('active', 'border-blue-600');
                    thumb.classList.add('border-gray-200');
                });
                
                element.classList.add('active', 'border-blue-600');
                element.classList.remove('border-gray-200');
            }
        }

        // Add fade-in animation on load
        document.addEventListener('DOMContentLoaded', function() {
            const fadeElements = document.querySelectorAll('.fade-in');
            fadeElements.forEach((el, index) => {
                setTimeout(() => {
                    el.style.opacity = '1';
                }, index * 200);
            });
        });
    </script>
</body>
</html>