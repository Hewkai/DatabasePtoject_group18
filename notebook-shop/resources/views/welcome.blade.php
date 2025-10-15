<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            * {
                -webkit-overflow-scrolling: touch;
            }
            
            html {
                scroll-behavior: smooth;
                overflow: hidden;
            }
            
            body {
                scroll-snap-type: both mandatory;
                -webkit-overflow-scrolling: touch;
                overscroll-behavior: contain;
            }
            
            /* Section animations */
            .section-content {
                opacity: 1;
                transition: opacity 0.6s ease-in-out;
                scroll-snap-align: start;
                scroll-snap-stop: always;
            }
            
            /* Hero section specific animations */
            .hero-text {
                animation: slideInLeft 0.8s ease-out;
            }
            
            .hero-image {
                animation: slideInRight 0.8s ease-out;
            }
            
            /* Testimonial section animations */
            .testimonial-image {
                animation: slideInLeft 0.8s ease-out;
            }
            
            .testimonial-text {
                animation: slideInRight 0.8s ease-out;
            }
            
            @keyframes slideInLeft {
                from {
                    opacity: 0;
                    transform: translateX(-50px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            
            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(50px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            
            /* Features section animations */
            .features-title {
                animation: fadeInDown 0.8s ease-out;
            }
            
            @keyframes fadeInDown {
                from {
                    opacity: 0;
                    transform: translateY(-30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .fade-in-up {
                opacity: 0;
                transform: translateY(50px);
                transition: opacity 0.8s ease-out, transform 0.8s ease-out;
            }
            
            .fade-in-up.visible {
                opacity: 1;
                transform: translateY(0);
            }
            
            .stagger-1 {
                transition-delay: 0.2s;
            }
            
            .stagger-2 {
                transition-delay: 0.4s;
            }
            
            .stagger-3 {
                transition-delay: 0.6s;
            }

            .product-card {
                transition: all 0.3s ease;
                opacity: 0;
                transform: translateY(20px);
            }

            .product-card.show {
                opacity: 1;
                transform: translateY(0);
            }

            .product-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            }

            .color-option {
                transition: all 0.2s ease;
                cursor: pointer;
            }

            .color-option:hover {
                transform: scale(1.2);
            }

            /* Brand filter scrollbar */
            .brand-scroll::-webkit-scrollbar {
                width: 4px;
            }

            .brand-scroll::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            .brand-scroll::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 10px;
            }

            .brand-scroll::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }

            .brand-button {
                transition: all 0.2s ease;
            }

            .brand-button:hover {
                transform: scale(1.02);
            }

            .brand-button.active {
                background: #2563eb;
                color: white;
            }
        </style>
    </head>
    <body class="bg-white font-sans antialiased snap-both snap-mandatory h-screen overflow-auto">
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
                                $cartCount = 0;
                            @endphp
                            <span class="absolute -top-2 -right-2 bg-blue-600 text-white text-xs {{ $cartCount > 99 ? 'min-w-[24px] px-1' : 'w-5' }} h-5 flex items-center justify-center rounded-full font-semibold">
                                {{ $cartCount > 99 ? '99+' : $cartCount }}
                            </span>
                        </a>

                        <!-- User Profile / Login Button -->
                        @if (Route::has('login'))
                            @auth
                                <!-- Profile Dropdown -->
                                <div class="relative group">
                                    <button class="flex items-center gap-3 hover:opacity-80 transition">
                                        <!-- Profile Image -->
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold shadow-md overflow-hidden">
                                            @if(Auth::user()->profile_photo_path)
                                                <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                            @else
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            @endif
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
                                            
                                            @if (auth()->user()->is_admin)
                                                <a href="/admin" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-gray-50 transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    Admin
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
        </nav>

        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-gray-50 via-white to-blue-50 min-h-screen flex items-center snap-start snap-always section-content">
            <div class="max-w-7xl mx-auto px-8 w-full">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div class="space-y-6 hero-text">
                        <h1 class="text-6xl lg:text-7xl font-bold text-blue-600 leading-tight" style="font-family: 'Anton', sans-serif;">
                            Power Up Your<br>Performance
                        </h1>
                        
                        <p class="text-gray-600 text-lg leading-relaxed max-w-xl">
                            Discover high-performance laptops and PCs built for study, work, and creativity. 
                            Boost your productivity with the latest technology.
                        </p>

                        <div class="pt-4">
                            <a href="{{ url('/products') }}" class="inline-block bg-blue-600 text-white px-8 py-3.5 rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-600/30">
                                Shop Now
                            </a>
                        </div>
                    </div>

                    <!-- Right Content - Product Images -->
                    <div class="relative hero-image">
                        <img src="{{ asset('images/gaming-setup.png') }}" alt="Gaming Setup" class="w-full h-auto object-contain drop-shadow-2xl">
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="min-h-screen bg-white relative overflow-hidden flex items-center snap-start snap-always section-content">
            <!-- Decorative dots -->
            <div class="absolute top-20 left-10 w-3 h-3 bg-red-400 rounded-full"></div>
            <div class="absolute top-32 right-20 w-3 h-3 bg-yellow-400 rounded-full"></div>
            
            <div class="max-w-7xl mx-auto px-8 py-20 w-full">
                <!-- Section Title -->
                <div class="text-center mb-20 features-title">
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                        Your Trusted Computer<br>Partner
                    </h2>
                </div>

                <!-- Features Grid -->
                <div class="grid md:grid-cols-3 gap-12 lg:gap-16">
                    <!-- Feature 1: Easy To Order -->
                    <div class="text-center fade-in-up stagger-1">
                        <div class="mb-6 flex justify-center">
                            <div class="w-32 h-32 flex items-center justify-center">
                                <svg class="w-30 h-30" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Shopping Cart -->
                                    <path d="M25 35H95L85 75H35L25 35Z" fill="#A5B4FC" stroke="#6366F1" stroke-width="2"/>
                                    <circle cx="45" cy="85" r="5" fill="#6366F1"/>
                                    <circle cx="75" cy="85" r="5" fill="#6366F1"/>
                                    <path d="M20 25H30L35 35" stroke="#6366F1" stroke-width="2" stroke-linecap="round"/>
                                    <!-- Checkmark -->
                                    <circle cx="70" cy="45" r="12" fill="#6366F1"/>
                                    <path d="M65 45L68 48L75 41" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="28" cy="92" r="3" fill="#3B82F6"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Easy To Order</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Choose your favorite models and order online in just a few clicks.
                        </p>
                    </div>

                    <!-- Feature 2: Fastest Delivery -->
                    <div class="text-center fade-in-up stagger-2">
                        <div class="mb-6 flex justify-center">
                            <div class="w-32 h-32 flex items-center justify-center">
                                <svg class="w-30 h-30" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Truck Body -->
                                    <rect x="25" y="50" width="45" height="25" rx="3" fill="#93C5FD" stroke="#3B82F6" stroke-width="2"/>
                                    <rect x="70" y="55" width="20" height="20" rx="2" fill="#3B82F6"/>
                                    <!-- Wheels -->
                                    <circle cx="45" cy="80" r="6" fill="#1E40AF" stroke="#3B82F6" stroke-width="2"/>
                                    <circle cx="80" cy="80" r="6" fill="#1E40AF" stroke="#3B82F6" stroke-width="2"/>
                                    <!-- Speed lines -->
                                    <line x1="15" y1="55" x2="22" y2="55" stroke="#3B82F6" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="12" y1="62" x2="20" y2="62" stroke="#3B82F6" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="15" y1="69" x2="22" y2="69" stroke="#3B82F6" stroke-width="2" stroke-linecap="round"/>
                                    <!-- Clock icon -->
                                    <circle cx="80" cy="40" r="10" fill="#FCD34D" stroke="#F59E0B" stroke-width="2"/>
                                    <path d="M80 35V40L83 43" stroke="#F59E0B" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Fastest Delivery</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Get your laptop delivered safely and quickly to your doorstep.
                        </p>
                    </div>

                    <!-- Feature 3: Best Quality -->
                    <div class="text-center fade-in-up stagger-3">
                        <div class="mb-6 flex justify-center">
                            <div class="w-32 h-32 flex items-center justify-center">
                                <svg class="w-30 h-30" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Hands -->
                                    <path d="M30 75L35 65L40 70L35 85L30 75Z" fill="#93C5FD" stroke="#3B82F6" stroke-width="2"/>
                                    <path d="M90 75L85 65L80 70L85 85L90 75Z" fill="#93C5FD" stroke="#3B82F6" stroke-width="2"/>
                                    <ellipse cx="35" cy="87" rx="8" ry="5" fill="#93C5FD" stroke="#3B82F6" stroke-width="2"/>
                                    <ellipse cx="85" cy="87" rx="8" ry="5" fill="#93C5FD" stroke="#3B82F6" stroke-width="2"/>
                                    <!-- Medal/Badge -->
                                    <circle cx="60" cy="50" r="18" fill="#3B82F6"/>
                                    <circle cx="60" cy="50" r="14" fill="#60A5FA"/>
                                    <path d="M60 42L62 48L68 48L63 52L65 58L60 54L55 58L57 52L52 48L58 48L60 42Z" fill="white"/>
                                    <!-- Checkmark in circle -->
                                    <circle cx="60" cy="50" r="20" stroke="#3B82F6" stroke-width="2" fill="none"/>
                                    <path d="M52 50L57 55L68 44" stroke="#1E40AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Best Quality</h3>
                        <p class="text-gray-600 leading-relaxed">
                            We offer only genuine products with full warranty.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonial Section -->
        <section class="min-h-screen bg-gray-50 relative overflow-hidden flex items-center snap-start snap-always section-content">
            <!-- Decorative dots -->
            <div class="absolute top-24 right-16 w-3 h-3 bg-yellow-400 rounded-full"></div>
            <div class="absolute bottom-32 left-24 w-3 h-3 bg-blue-500 rounded-full"></div>
            
            <div class="max-w-7xl mx-auto px-8 py-20 w-full">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <!-- Left Content - Laptop Image -->
                    <div class="relative testimonial-image">
                        <div class="relative">
                            <!-- Blue blob background -->
                            <div class="absolute inset-0 bg-blue-200 rounded-full blur-3xl opacity-30 transform -rotate-12"></div>
                            <!-- Laptop mockup -->
                            <div class="relative z-10">
                                <img src="{{ asset('images/gaming-laptop.png') }}" alt="Gaming Laptop" class="w-full h-auto object-contain drop-shadow-2xl">
                            </div>
                        </div>
                    </div>

                    <!-- Right Content - Testimonial -->
                    <div class="space-y-6 testimonial-text">
                        <div>
                            <p class="text-blue-600 font-semibold text-sm uppercase tracking-wider mb-3">WHAT THEY SAY</p>
                            <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                                What Our Customers<br>Say About Us
                            </h2>
                        </div>

                        <blockquote class="text-gray-700 text-lg leading-relaxed mb-6">
                            "I bought my first gaming laptop here – super smooth process and fast delivery! Definitely recommended."
                        </blockquote>

                        <!-- Star Rating -->
                        <div class="flex items-center gap-3">
                            <div class="flex gap-1">
                                <!-- Full stars -->
                                <svg class="w-7 h-7 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg class="w-7 h-7 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg class="w-7 h-7 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg class="w-7 h-7 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <!-- Half star -->
                                <svg class="w-7 h-7" viewBox="0 0 24 24">
                                    <defs>
                                        <linearGradient id="half-star-gradient">
                                            <stop offset="50%" stop-color="#FBBF24"/>
                                            <stop offset="50%" stop-color="#D1D5DB"/>
                                        </linearGradient>
                                    </defs>
                                    <path fill="url(#half-star-gradient)" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                            <span class="text-2xl font-bold text-gray-900">4.8</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Products Section - Backend Integration -->
        <section id="products-section" class="min-h-screen bg-white relative overflow-hidden flex items-center snap-start snap-always section-content">
            <!-- Decorative dots -->
            <div class="absolute top-16 left-1/3 w-3 h-3 bg-yellow-400 rounded-full"></div>
            
            <div class="max-w-7xl mx-auto px-8 py-20 w-full">
                <!-- Section Header -->
                <div class="mb-12 products-header">
                    <p class="text-blue-600 font-semibold text-sm uppercase tracking-wider mb-3">OUR MENU</p>
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900">
                        Tech That You'll<br>Fall In Love With
                    </h2>
                </div>

                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Brand Filter Sidebar -->
                    <div class="lg:w-64 flex-shrink-0">
                        <div id="brand-filters" class="space-y-3 brand-scroll max-h-[300px] overflow-y-auto pr-2">
                            <!-- Brands will be loaded here -->
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="flex-1">
                        <!-- Navigation Arrows -->
                        <div class="flex justify-end gap-3 mb-6">
                            <button id="prev-page" class="w-12 h-12 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center transition">
                                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button id="next-page" class="w-12 h-12 rounded-full bg-blue-600 hover:bg-blue-700 flex items-center justify-center transition">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>

                        <!-- Loading State -->
                        <div id="loading-products" class="text-center py-12">
                            <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-blue-600"></div>
                            <p class="mt-4 text-gray-600">กำลังโหลดสินค้า...</p>
                        </div>

                        <!-- Error State -->
                        <div id="error-products" class="hidden bg-red-50 border-2 border-red-200 rounded-xl p-6 text-center">
                            <p class="text-red-600 font-semibold"></p>
                        </div>

                        <!-- Products Grid Container -->
                        <div id="products-grid" class="hidden grid md:grid-cols-2 gap-6">
                            <!-- Products will be loaded here via JavaScript -->
                        </div>

                        <!-- Empty State -->
                        <div id="empty-products" class="hidden grid md:grid-cols-2 gap-6">
                            <!-- Product Card 1 - Placeholder -->
                            <div class="bg-gray-50 rounded-2xl p-6 border-2 border-dashed border-gray-300 fade-in-up stagger-1">
                                <div class="aspect-video bg-gray-200 rounded-xl mb-4 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-400 mb-2">No Product Yet</h3>
                                <p class="text-sm text-gray-400 mb-3">Product details will appear here</p>
                                <div class="flex gap-2 mb-3">
                                    <span class="w-6 h-6 rounded-full bg-gray-300"></span>
                                    <span class="w-6 h-6 rounded-full bg-gray-300"></span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="px-3 py-1 bg-gray-300 text-gray-500 rounded-full text-xs font-medium">Coming Soon</span>
                                    <span class="text-xl font-bold text-gray-400">฿ ---</span>
                                </div>
                            </div>

                            <!-- Product Card 2 - Placeholder -->
                            <div class="bg-gray-50 rounded-2xl p-6 border-2 border-dashed border-gray-300 fade-in-up stagger-2">
                                <div class="aspect-video bg-gray-200 rounded-xl mb-4 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-400 mb-2">No Product Yet</h3>
                                <p class="text-sm text-gray-400 mb-3">Product details will appear here</p>
                                <div class="flex gap-2 mb-3">
                                    <span class="w-6 h-6 rounded-full bg-gray-300"></span>
                                    <span class="w-6 h-6 rounded-full bg-gray-300"></span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="px-3 py-1 bg-gray-300 text-gray-500 rounded-full text-xs font-medium">Coming Soon</span>
                                    <span class="text-xl font-bold text-gray-400">฿ ---</span>
                                </div>
                            </div>
                        </div>

                        <p id="empty-text" class="hidden text-center text-gray-500 mt-8 text-sm">
                            🚀 Products will be displayed here once available
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-12 snap-start">
            <div class="max-w-7xl mx-auto px-8">
                <div class="grid md:grid-cols-5 gap-8 mb-8">
                    <!-- Brand Column -->
                    <div class="md:col-span-1">
                        <h3 class="text-blue-600 font-bold text-xl mb-4">comp</h3>
                        <p class="text-gray-600 text-sm leading-relaxed mb-4">
                            Our job is to filling your tummy with delicious food and with fast and free delivery.
                        </p>
                        <div class="flex gap-3">
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-blue-600 hover:text-white flex items-center justify-center transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-blue-600 hover:text-white flex items-center justify-center transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-blue-600 hover:text-white flex items-center justify-center transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- About Column -->
                    <div>
                        <h4 class="font-bold text-gray-900 mb-4">About</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">About Us</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Features</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">News</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Menu</a></li>
                        </ul>
                    </div>

                    <!-- Company Column -->
                    <div>
                        <h4 class="font-bold text-gray-900 mb-4">Company</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Why Us?</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Partner With Us</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">FAQ</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Blog</a></li>
                        </ul>
                    </div>

                    <!-- Support Column -->
                    <div>
                        <h4 class="font-bold text-gray-900 mb-4">Support</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Account</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Support Center</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Feedback</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Contact Us</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Accessibility</a></li>
                        </ul>
                    </div>

                    <!-- Get in Touch Column -->
                    <div>
                        <h4 class="font-bold text-gray-900 mb-4">Get in Touch</h4>
                        <p class="text-sm text-gray-600 mb-4">Question or feedback?<br>We'd love to hear from you</p>
                        <div class="flex gap-2">
                            <input type="email" placeholder="Email Address" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-600">
                            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Bottom Footer -->
                <div class="pt-8 border-t border-gray-200 text-center text-sm text-gray-500">
                    <p>&copy; 2024 COMP. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <script>
            // Constants
            const CSRF = @json(csrf_token());
            const LOGGED_IN = @json(auth()->check());
            
            // DOM Elements
            const loadingEl = document.getElementById('loading-products');
            const errorEl = document.getElementById('error-products');
            const gridEl = document.getElementById('products-grid');
            const emptyEl = document.getElementById('empty-products');
            const emptyTextEl = document.getElementById('empty-text');
            const brandFiltersEl = document.getElementById('brand-filters');
            const prevPageBtn = document.getElementById('prev-page');
            const nextPageBtn = document.getElementById('next-page');
            
            let allProducts = [];
            let filteredProducts = [];
            let currentPage = 0;
            const itemsPerPage = 2;
            let currentBrand = 'All';

            // Format price
            function formatPrice(price) {
                if (price === null || price === undefined || price === '') return '-';
                const num = Number(price);
                if (Number.isNaN(num)) return String(price);
                return num.toLocaleString('th-TH', { style: 'currency', currency: 'THB', maximumFractionDigits: 0 });
            }

            // Create product card HTML (แบบ welcome.blade1.php)
            function createProductCard(product) {
                const brand = product.brand?.name ?? '-';
                const img = product.primary_image?.url ?? null;
                const detailUrl = `/product/${product.id}`;
                
                // สร้าง description จาก specs
                const cpu = [product.cpu_brand, product.cpu_model].filter(Boolean).join(' ');
                const ram = product.ram_gb ? `${product.ram_gb}GB RAM` : '';
                const storage = product.storage_gb ? `${product.storage_gb}GB SSD` : '';
                const gpu = product.gpu ? `GPU: ${product.gpu}` : '';
                
                const description = [cpu, ram, storage].filter(Boolean).join(' • ');

                const addToCartBtn = LOGGED_IN
                    ? `<form method="post" action="/cart/add" class="inline">
                         <input type="hidden" name="_token" value="${CSRF}">
                         <input type="hidden" name="product_id" value="${product.id}">
                         <button type="submit" class="w-10 h-10 bg-white border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 flex items-center justify-center transition">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                         </button>
                       </form>`
                    : `<button onclick="window.location.href='/login'" class="w-10 h-10 bg-gray-200 border-2 border-gray-300 rounded-lg cursor-pointer hover:bg-gray-300 flex items-center justify-center transition">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                       </button>`;

                return `
                    <div class="bg-gray-50 rounded-3xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 product-card">
                        <div class="flex gap-6">
                            <!-- Product Image - Left Side -->
                            <div class="w-1/2 flex-shrink-0">
                                <a href="${detailUrl}" class="relative bg-white rounded-2xl p-4 h-full flex items-center justify-center block">
                                    ${img 
                                        ? `<img src="${img}" alt="${brand} ${product.model}" class="w-full h-auto object-contain">` 
                                        : `<div class="w-full h-32 flex items-center justify-center text-gray-300">
                                             <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                             </svg>
                                           </div>`
                                    }
                                </a>
                            </div>

                            <!-- Product Info - Right Side -->
                            <div class="w-1/2 flex flex-col justify-between">
                                <div class="space-y-3">
                                    <!-- Title -->
                                    <a href="${detailUrl}">
                                        <h3 class="text-lg font-bold text-gray-900 leading-tight hover:text-blue-600 transition">${brand} ${product.model}</h3>
                                    </a>
                                    
                                    <!-- Description -->
                                    <p class="text-xs text-gray-600 leading-relaxed">${description || 'No description available'}</p>

                                    <!-- GPU Info -->
                                    ${gpu ? `<p class="text-xs text-gray-600">${gpu}</p>` : ''}

                                    <!-- Status Badge -->
                                    <div>
                                        <span class="inline-flex px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                            Available
                                        </span>
                                    </div>
                                </div>

                                <!-- Price and Actions -->
                                <div class="mt-4 flex items-center justify-between">
                                    <div class="text-xl font-bold text-gray-900">
                                        ${formatPrice(product.price)}
                                    </div>
                                    
                                    <div class="flex items-center gap-2">
                                        <!-- Add to Cart Button -->
                                        ${addToCartBtn}

                                        <!-- Favorite Button -->
                                        <button class="w-10 h-10 bg-white border-2 border-gray-200 rounded-lg hover:border-gray-400 hover:bg-gray-50 flex items-center justify-center transition">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

            // Show specific page with animation
            function showPage(pageIndex, animated = true) {
                const start = pageIndex * itemsPerPage;
                const end = start + itemsPerPage;
                const productsToShow = filteredProducts.slice(start, end);

                if (productsToShow.length === 0) {
                    gridEl.classList.add('hidden');
                    emptyEl.classList.remove('hidden');
                    emptyTextEl.classList.remove('hidden');
                } else {
                    // Fade out current cards if animated
                    if (animated && gridEl.children.length > 0) {
                        gridEl.classList.add('transitioning');
                        const currentCards = gridEl.querySelectorAll('.product-card');
                        currentCards.forEach(card => {
                            card.classList.add('fade-out');
                        });

                        // Wait for fade out animation
                        setTimeout(() => {
                            renderNewProducts(productsToShow);
                        }, 300);
                    } else {
                        renderNewProducts(productsToShow);
                    }
                }

                currentPage = pageIndex;
            }

            // Render new products with animation
            function renderNewProducts(productsToShow) {
                gridEl.innerHTML = productsToShow.map(createProductCard).join('');
                gridEl.classList.remove('hidden', 'transitioning');
                emptyEl.classList.add('hidden');
                emptyTextEl.classList.add('hidden');
                
                // Scroll to products section smoothly
                const productsSection = document.getElementById('products-section');
                if (productsSection) {
                    const yOffset = -100;
                    const y = productsSection.getBoundingClientRect().top + window.pageYOffset + yOffset;
                    window.scrollTo({ top: y, behavior: 'smooth' });
                }
                
                // Add stagger animation to cards
                setTimeout(() => {
                    const cards = gridEl.querySelectorAll('.product-card');
                    cards.forEach((card, index) => {
                        setTimeout(() => {
                            card.classList.add('show');
                        }, index * 150); // Stagger by 150ms
                    });
                }, 50);
            }

            // Next page
            function nextPage() {
                const totalPages = Math.ceil(filteredProducts.length / itemsPerPage);
                if (currentPage < totalPages - 1) {
                    showPage(currentPage + 1, true);
                }
            }

            // Previous page
            function previousPage() {
                if (currentPage > 0) {
                    showPage(currentPage - 1, true);
                }
            }

            // Filter products by brand
            function filterByBrand(brandName) {
                currentBrand = brandName;
                
                // Update active button
                document.querySelectorAll('.brand-button').forEach(btn => {
                    btn.classList.remove('active');
                    btn.classList.add('border-2', 'border-gray-200', 'hover:border-blue-600');
                    const textSpan = btn.querySelector('span:last-child');
                    if (textSpan) textSpan.classList.add('text-gray-700');
                });
                
                const activeBtn = event.target.closest('.brand-button');
                if (activeBtn) {
                    activeBtn.classList.add('active');
                    activeBtn.classList.remove('border-2', 'border-gray-200', 'hover:border-blue-600');
                    const textSpan = activeBtn.querySelector('span:last-child');
                    if (textSpan) textSpan.classList.remove('text-gray-700');
                }

                // Filter products
                if (brandName === 'All') {
                    filteredProducts = [...allProducts];
                } else {
                    filteredProducts = allProducts.filter(p => p.brand?.name === brandName);
                }

                // Reset to first page with animation
                currentPage = 0;
                showPage(currentPage, true);
            }

            // Create brand filters
            function createBrandFilters() {
                // Get unique brands from products
                const brands = [...new Set(allProducts.map(p => p.brand?.name).filter(Boolean))];
                
                // Add "All" option
                let filtersHTML = `
                    <button class="brand-button active w-full flex items-center gap-3 px-6 py-3 rounded-full transition text-left" onclick="filterByBrand('All')">
                        <span class="text-2xl">🏪</span>
                        <span class="font-medium">All</span>
                    </button>
                `;

                // Add brand buttons
                brands.forEach(brand => {
                    const emoji = getBrandEmoji(brand);
                    filtersHTML += `
                        <button class="brand-button w-full flex items-center gap-3 px-6 py-3 rounded-full border-2 border-gray-200 hover:border-blue-600 transition text-left" onclick="filterByBrand('${brand}')">
                            <span class="text-2xl">${emoji}</span>
                            <span class="font-medium text-gray-700">${brand}</span>
                        </button>
                    `;
                });

                brandFiltersEl.innerHTML = filtersHTML;
            }

            // Get emoji for brand
            function getBrandEmoji(brand) {
                const emojiMap = {
                    'Asus': '🔵',
                    'Apple': '🍎',
                    'HP': '🍕',
                    'Hp': '🍕',
                    'Dell': '💻',
                    'Lenovo': '🖥️',
                    'Acer': '⚡',
                    'MSI': '🎮',
                    'Razer': '🐍'
                };
                return emojiMap[brand] || '💼';
            }

            // Load products from API
            async function loadProducts() {
                try {
                    const response = await fetch('/api/products?per_page=60', {
                        headers: { 'Accept': 'application/json' }
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}`);
                    }

                    const json = await response.json();
                    const products = Array.isArray(json.data) ? json.data : Array.isArray(json) ? json : [];
                    
                    allProducts = products;
                    filteredProducts = [...allProducts];
                    
                    // Create brand filters
                    createBrandFilters();
                    
                    // Show first page without animation (initial load)
                    showPage(0, false);
                    
                    loadingEl.classList.add('hidden');
                    
                    // Add entrance animation for the whole products section
                    setTimeout(() => {
                        const cards = gridEl.querySelectorAll('.product-card');
                        cards.forEach((card, index) => {
                            setTimeout(() => {
                                card.classList.add('show');
                            }, index * 200); // Slower stagger for initial load
                        });
                    }, 100);
                } catch (error) {
                    loadingEl.classList.add('hidden');
                    errorEl.classList.remove('hidden');
                    errorEl.querySelector('p').textContent = 'โหลดข้อมูลไม่สำเร็จ: ' + (error?.message ?? error);
                }
            }

            // Event listeners
            prevPageBtn.addEventListener('click', previousPage);
            nextPageBtn.addEventListener('click', nextPage);

            // Make filterByBrand global
            window.filterByBrand = filterByBrand;

            // Intersection Observer for scroll animations
            document.addEventListener('DOMContentLoaded', function() {
                const observerOptions = {
                    threshold: 0.2,
                    rootMargin: '0px 0px -50px 0px'
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                        }
                    });
                }, observerOptions);

                // Observe all elements with fade-in-up class
                document.querySelectorAll('.fade-in-up').forEach(el => {
                    observer.observe(el);
                });

                // Load products
                loadProducts();
            });
        </script>
    </body>
</html>