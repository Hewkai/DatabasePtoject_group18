<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Products - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
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

        .favorite-btn {
            transition: all 0.2s ease;
        }

        .favorite-btn:hover {
            transform: scale(1.1);
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

        /* Fixed height for both sections */
        .section-container {
            height: 290px;
        }

        /* Category scrollbar */
        .category-scroll {
            max-height: 200px;
            overflow-y: auto;
        }

        .category-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .category-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .category-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .category-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .category-button, .brand-button {
            transition: all 0.2s ease;
        }

        .category-button:hover, .brand-button:hover {
            transform: scale(1.02);
        }

        .category-button.active, .brand-button.active {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
        }

        /* Brand carousel styles */
        .brand-carousel-container {
            position: relative;
            overflow: hidden;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding-top: 0.5rem;
            padding-left: 0.5rem;
        }

        .brand-carousel {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 0.5rem;
            transition: transform 0.3s ease;
            align-items: center;
            margin: 0;
        }

        .brand-button {
            padding: 1rem;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-button span {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .carousel-dots {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
            padding-top: 0;
        }

        .carousel-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #d1d5db;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .carousel-dot.active {
            background: #2563eb;
            width: 24px;
            border-radius: 4px;
        }

        .carousel-dot:hover {
            background: #9ca3af;
        }

        @media (max-width: 768px) {
            .brand-carousel {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .section-container {
                height: auto;
                min-height: 300px;
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Navigation -->
    @include('layouts.navigation')
    <!-- Main Content -->
    <div class="min-h-screen bg-gray-50">
        <!-- Page Header with Search -->
        <div class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Search Bar -->
                <div class="max-w-2xl mx-auto">
                    <div class="relative">
                        <input 
                            type="text" 
                            id="search-input"
                            placeholder="Search products..." 
                            class="w-full px-6 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                        <button class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Category and Featured Brands Row -->
            <div class="flex flex-col lg:flex-row gap-8 mb-8">
                <!-- Category Section -->
                <div class="lg:w-64 flex-shrink-0">
                    <div class="bg-white rounded-2xl p-6 shadow-sm section-container flex flex-col">
                        <h3 class="text-xl font-bold text-blue-600 mb-6 border-b-2 border-blue-600 pb-2 inline-block">Category</h3>
                        
                        <div id="category-filters" class="space-y-3 category-scroll flex-1">
                            <!-- Categories will be loaded here -->
                        </div>
                    </div>
                </div>

                <!-- Featured Brands Section -->
                <div class="flex-1">
                    <div class="bg-white rounded-2xl p-6 shadow-sm section-container flex flex-col">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">FEATURED BRANDS</h3>
                        
                        <div class="brand-carousel-container">
                            <div id="brand-carousel" class="brand-carousel">
                                <!-- Brand buttons will be loaded here (max 10 visible) -->
                            </div>
                        </div>

                        <!-- Carousel Dots -->
                        <div id="carousel-dots" class="carousel-dots">
                            <!-- Dots will be generated here -->
                        </div>
                    </div>
                </div>
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

            <!-- Products Section -->
            <div id="products-container" class="hidden">
                <div id="products-grid" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Products will be loaded here via JavaScript -->
                </div>

                <!-- Pagination -->
                <div class="flex justify-center items-center gap-4 mt-8">
                    <button id="prev-page" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg font-medium transition disabled:opacity-50 disabled:cursor-not-allowed">
                        Previous
                    </button>
                    <span id="page-info" class="text-gray-600 font-medium"></span>
                    <button id="next-page" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition disabled:opacity-50 disabled:cursor-not-allowed">
                        Next
                    </button>
                </div>
            </div>

            <!-- Empty State -->
            <div id="empty-products" class="hidden bg-white rounded-2xl p-12 shadow-sm text-center">
                <div class="max-w-md mx-auto space-y-6">
                    <!-- Empty Icon -->
                    <div class="flex justify-center">
                        <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Empty Message -->
                    <div class="space-y-2">
                        <h3 class="text-2xl font-bold text-gray-900">ไม่มีสินค้า</h3>
                        <p class="text-gray-600">ขณะนี้ยังไม่มีสินค้าในหมวดหมู่นี้</p>
                    </div>

                    <!-- Back Button -->
                    <a 
                        href="{{ url('/') }}" 
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        กลับหน้าหลัก
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Constants
        const CSRF = @json(csrf_token());
        const LOGGED_IN = @json(auth()->check());
        
        // DOM Elements
        const loadingEl = document.getElementById('loading-products');
        const errorEl = document.getElementById('error-products');
        const productsContainer = document.getElementById('products-container');
        const gridEl = document.getElementById('products-grid');
        const emptyEl = document.getElementById('empty-products');
        const categoryFiltersEl = document.getElementById('category-filters');
        const brandCarouselEl = document.getElementById('brand-carousel');
        const carouselDotsEl = document.getElementById('carousel-dots');
        const searchInput = document.getElementById('search-input');
        const prevPageBtn = document.getElementById('prev-page');
        const nextPageBtn = document.getElementById('next-page');
        const pageInfo = document.getElementById('page-info');
        
        let allProducts = [];
        let filteredProducts = [];
        let currentPage = 1;
        let totalPages = 1;
        let currentCategory = 'All';
        let currentBrand = null;
        let searchQuery = '';
        let currentCarouselPage = 0;
        let totalCarouselPages = 1;
        const brandsPerPage = 10; // แสดง 2 แถว x 5 แบรนด์ = 10 แบรนด์ต่อหน้า

        // Format price
        function formatPrice(price) {
            if (price === null || price === undefined || price === '') return '-';
            const num = Number(price);
            if (Number.isNaN(num)) return String(price);
            return num.toLocaleString('th-TH', { style: 'currency', currency: 'THB', maximumFractionDigits: 0 });
        }

        // Create product card HTML
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
                     <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition flex items-center justify-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Add to Cart
                     </button>
                   </form>`
                : `<button onclick="window.location.href='/login'" class="flex-1 px-4 py-2 bg-gray-300 text-gray-500 font-medium rounded-lg cursor-not-allowed flex items-center justify-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Login to Add
                   </button>`;

            return `
                <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 product-card">
                    <div class="flex gap-6">
                        <!-- Product Image - Left Side (50%) -->
                        <div class="w-1/2 flex-shrink-0">
                            <a href="${detailUrl}" class="relative bg-gray-50 rounded-xl p-6 h-full flex items-center justify-center block">
                                ${img 
                                    ? `<img src="${img}" alt="${brand} ${product.model}" class="w-full h-48 object-contain">` 
                                    : `<div class="w-full h-48 flex items-center justify-center text-gray-300">
                                         <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                         </svg>
                                       </div>`
                                }
                            </a>
                        </div>

                        <!-- Product Info - Right Side (50%) -->
                        <div class="w-1/2 flex flex-col justify-between">
                            <div class="space-y-3">
                                <!-- Title -->
                                <a href="${detailUrl}">
                                    <h3 class="text-lg font-bold text-gray-900 line-clamp-2 hover:text-blue-600 transition">${brand} ${product.model}</h3>
                                </a>
                                
                                <!-- Description -->
                                <p class="text-sm text-gray-600 line-clamp-2">${description || 'No description available'}</p>

                                <!-- GPU Info -->
                                ${gpu ? `<p class="text-xs text-gray-600">${gpu}</p>` : ''}

                                <!-- Status -->
                                <div>
                                    <span class="inline-flex px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                        Available
                                    </span>
                                </div>
                            </div>

                            <!-- Price and Actions -->
                            <div class="space-y-3 mt-4">
                                <div class="text-2xl font-bold text-gray-900">
                                    ${formatPrice(product.price)}
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <!-- Add to Cart Button -->
                                    ${addToCartBtn}

                                    <!-- Favorite Button -->
                                    <button 
                                        onclick="handleFavorite(${product.id})"
                                        class="w-10 h-10 bg-white border-2 border-gray-200 rounded-lg hover:border-red-300 hover:bg-red-50 flex items-center justify-center favorite-btn group transition"
                                    >
                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Render products
        function renderProducts() {
            if (filteredProducts.length === 0) {
                productsContainer.classList.add('hidden');
                emptyEl.classList.remove('hidden');
                return;
            }

            gridEl.innerHTML = filteredProducts.map(createProductCard).join('');
            productsContainer.classList.remove('hidden');
            emptyEl.classList.add('hidden');
            
            // Add animation
            setTimeout(() => {
                const cards = gridEl.querySelectorAll('.product-card');
                cards.forEach((card, index) => {
                    setTimeout(() => {
                        card.classList.add('show');
                    }, index * 100);
                });
            }, 50);

            // Update pagination info
            pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
            prevPageBtn.disabled = currentPage === 1;
            nextPageBtn.disabled = currentPage === totalPages;
        }

        // Create category filters
        function createCategoryFilters() {
            const categories = [...new Set(allProducts.flatMap(p => 
                p.categories?.map(c => c.name) || []
            ))].filter(Boolean);
            
            let filtersHTML = `
                <button class="category-button active w-full flex items-center gap-3 px-4 py-2 rounded-lg transition text-left" onclick="filterByCategory('All')">
                    <span class="text-xl">📦</span>
                    <span class="font-medium">All Products</span>
                </button>
            `;

            categories.forEach(category => {
                filtersHTML += `
                    <button class="category-button w-full flex items-center gap-3 px-4 py-2 rounded-lg border border-gray-200 hover:border-blue-600 transition text-left" onclick="filterByCategory('${category}')">
                        <span class="text-xl">🏷️</span>
                        <span class="font-medium text-gray-700">${category}</span>
                    </button>
                `;
            });

            categoryFiltersEl.innerHTML += filtersHTML;
        }

        // Create brand filters with carousel
        function createBrandFilters() {
            const brands = [...new Set(allProducts.map(p => p.brand?.name).filter(Boolean))];
            
            if (brands.length === 0) return;

            totalCarouselPages = Math.ceil(brands.length / brandsPerPage);
            
            let filtersHTML = '';
            brands.forEach(brand => {
                filtersHTML += `
                    <button class="brand-button flex items-center justify-center p-4 border-2 border-gray-100 rounded-xl hover:border-blue-200 transition" onclick="filterByBrand('${brand}')">
                        <span class="font-bold text-lg text-gray-700">${brand}</span>
                    </button>
                `;
            });

            brandCarouselEl.innerHTML = filtersHTML;

            // Create dots if more than brandsPerPage
            if (totalCarouselPages > 1) {
                createCarouselDots();
            } else {
                carouselDotsEl.innerHTML = '';
            }
        }

        // Create carousel dots
        function createCarouselDots() {
            let dotsHTML = '';
            for (let i = 0; i < totalCarouselPages; i++) {
                dotsHTML += `<button class="carousel-dot ${i === 0 ? 'active' : ''}" onclick="goToCarouselPage(${i})"></button>`;
            }
            carouselDotsEl.innerHTML = dotsHTML;
        }

        // Go to carousel page
        function goToCarouselPage(pageIndex) {
            currentCarouselPage = pageIndex;
            const brands = brandCarouselEl.querySelectorAll('.brand-button');
            
            // Hide all brands
            brands.forEach((brand, index) => {
                const start = currentCarouselPage * brandsPerPage;
                const end = start + brandsPerPage;
                
                if (index >= start && index < end) {
                    brand.style.display = 'flex';
                } else {
                    brand.style.display = 'none';
                }
            });

            // Update dots
            const dots = carouselDotsEl.querySelectorAll('.carousel-dot');
            dots.forEach((dot, index) => {
                if (index === currentCarouselPage) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }

        // Filter by category
        function filterByCategory(category) {
            currentCategory = category;
            currentPage = 1;
            
            // Update active button
            document.querySelectorAll('.category-button').forEach(btn => {
                btn.classList.remove('active');
                btn.classList.add('border', 'border-gray-200');
            });
            event.target.closest('.category-button').classList.add('active');
            event.target.closest('.category-button').classList.remove('border', 'border-gray-200');
            
            applyFilters();
        }

        // Filter by brand
        function filterByBrand(brand) {
            currentBrand = currentBrand === brand ? null : brand;
            currentPage = 1;
            
            // Update active button
            const clickedBtn = event.target.closest('.brand-button');
            if (clickedBtn.classList.contains('active')) {
                clickedBtn.classList.remove('active');
            } else {
                document.querySelectorAll('.brand-button').forEach(btn => btn.classList.remove('active'));
                clickedBtn.classList.add('active');
            }
            
            applyFilters();
        }

        // Apply all filters
        function applyFilters() {
            filteredProducts = allProducts.filter(product => {
                // Category filter
                if (currentCategory !== 'All') {
                    const hasCategory = product.categories?.some(c => c.name === currentCategory);
                    if (!hasCategory) return false;
                }
                
                // Brand filter
                if (currentBrand && product.brand?.name !== currentBrand) {
                    return false;
                }
                
                // Search filter
                if (searchQuery) {
                    const searchLower = searchQuery.toLowerCase();
                    const searchableText = [
                        product.model,
                        product.brand?.name,
                        product.cpu_model,
                        product.cpu_brand,
                        product.gpu
                    ].filter(Boolean).join(' ').toLowerCase();
                    
                    if (!searchableText.includes(searchLower)) {
                        return false;
                    }
                }
                
                return true;
            });
            
            totalPages = Math.ceil(filteredProducts.length / 20) || 1;
            renderProducts();
        }

        // Search functionality
        let searchTimeout;
        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                searchQuery = e.target.value.trim();
                currentPage = 1;
                applyFilters();
            }, 300);
        });

        // Pagination
        prevPageBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                loadProducts();
            }
        });

        nextPageBtn.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                loadProducts();
            }
        });

        // Handle favorite
        function handleFavorite(productId) {
            if (!LOGGED_IN) {
                window.location.href = '/login';
                return;
            }
            
            fetch(`/products/${productId}/favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Load products from API
        async function loadProducts() {
            try {
                const params = new URLSearchParams({
                    page: currentPage,
                    per_page: 20
                });

                if (currentCategory !== 'All') {
                    // Find category ID if needed
                    const categoryProduct = allProducts.find(p => 
                        p.categories?.some(c => c.name === currentCategory)
                    );
                    if (categoryProduct) {
                        const category = categoryProduct.categories.find(c => c.name === currentCategory);
                        if (category) {
                            params.append('category_id', category.id);
                        }
                    }
                }

                if (currentBrand) {
                    const brandProduct = allProducts.find(p => p.brand?.name === currentBrand);
                    if (brandProduct?.brand?.id) {
                        params.append('brand_id', brandProduct.brand.id);
                    }
                }

                if (searchQuery) {
                    params.append('q', searchQuery);
                }

                const response = await fetch(`/api/products?${params.toString()}`, {
                    headers: { 'Accept': 'application/json' }
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                const json = await response.json();
                const products = Array.isArray(json.data) ? json.data : Array.isArray(json) ? json : [];
                
                filteredProducts = products;
                totalPages = json.last_page || Math.ceil(json.total / 20) || 1;
                
                renderProducts();
                loadingEl.classList.add('hidden');
                
            } catch (error) {
                loadingEl.classList.add('hidden');
                errorEl.classList.remove('hidden');
                errorEl.querySelector('p').textContent = 'โหลดข้อมูลไม่สำเร็จ: ' + (error?.message ?? error);
            }
        }

        // Initial load - fetch all products first for filters
        async function initializeProducts() {
            try {
                const response = await fetch('/api/products?per_page=100', {
                    headers: { 'Accept': 'application/json' }
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                const json = await response.json();
                allProducts = Array.isArray(json.data) ? json.data : Array.isArray(json) ? json : [];
                filteredProducts = [...allProducts];
                
                // Create filters
                createCategoryFilters();
                createBrandFilters();
                
                // Show first page
                totalPages = Math.ceil(allProducts.length / 20) || 1;
                renderProducts();
                
                loadingEl.classList.add('hidden');
                
            } catch (error) {
                loadingEl.classList.add('hidden');
                errorEl.classList.remove('hidden');
                errorEl.querySelector('p').textContent = 'โหลดข้อมูลไม่สำเร็จ: ' + (error?.message ?? error);
            }
        }

        // Make functions globally accessible
        window.filterByCategory = filterByCategory;
        window.filterByBrand = filterByBrand;
        window.handleFavorite = handleFavorite;
        window.goToCarouselPage = goToCarouselPage;

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeProducts();
        });
    </script>
</body>
</html>