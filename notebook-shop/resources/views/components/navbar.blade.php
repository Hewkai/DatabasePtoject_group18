{{-- resources/views/components/navbar.blade.php --}}
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@500;600;700&display=swap" rel="stylesheet">
<style>
  .thai { font-family: 'Noto Sans Thai', system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; }
</style>

<header class="sticky top-0 z-50 bg-white thai border-b border-gray-100 shadow-sm/50">
  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center">

    {{-- ซ้าย: โลโก้ --}}
    <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
      <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center shadow-sm">
        <span class="block w-2.5 h-2.5 bg-white rounded-full"></span>
      </div>
      <span class="text-base font-semibold text-gray-900">Notebook Shop</span>
    </a>

    {{-- กลาง: เมนู --}}
    <nav class="hidden md:block absolute left-1/2 -translate-x-1/2">
      <ul class="flex items-center gap-8 text-sm font-medium">
        <li>
          <a href="{{ route('home') }}"
             class="transition {{ request()->routeIs('home') ? 'text-blue-700' : 'text-gray-600 hover:text-blue-700' }}">
            หน้าแรก
          </a>
        </li>
        <li>
          <a href="{{ route('products.index') }}"
             class="transition {{ request()->routeIs('products.index') ? 'text-blue-700' : 'text-gray-600 hover:text-blue-700' }}">
            สินค้า
          </a>
        </li>
        <li>
          <a href="{{ route('cart.index') }}"
             class="transition {{ request()->routeIs('cart.index') ? 'text-blue-700' : 'text-gray-600 hover:text-blue-700' }}">
            ตะกร้า
          </a>
        </li>
      </ul>
    </nav>

    {{-- ขวา: โปรไฟล์ / ปุ่มเข้า-ออกระบบ --}}
    <div class="ml-auto flex items-center gap-3">

      @guest
        <a href="{{ route('login') }}"
           class="hidden sm:inline-flex items-center rounded-full border border-gray-300 px-4 h-9 text-sm text-gray-700 hover:bg-gray-50">
          เข้าสู่ระบบ
        </a>
        <a href="{{ route('register') }}"
           class="inline-flex items-center rounded-full bg-blue-600 text-white px-4 h-9 text-sm font-medium hover:bg-blue-700">
          สมัครสมาชิก
        </a>
      @endguest

      @auth
        @php
          $u = auth()->user();
          $avatarPath = $u?->avatar_path;
          $avatarUrl  = $avatarPath ? asset('storage/'.$avatarPath) : asset('pic/user.png');
          $cacheBust  = $u?->updated_at ? '?t='.$u->updated_at->timestamp : '';
        @endphp


        {{-- รูปโปรไฟล์ (คลิกเพื่อแก้ไข) --}}
        <a href="{{ route('profile.edit') }}" class="flex items-center">
          <img src="{{ asset('pic/Profile.png') }}" alt="cart" class="w-6 h-6 hover:opacity-80 transition">

        </a>

        {{-- ปุ่มออกจากระบบ --}}
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit"
                  class="inline-flex items-center rounded-full bg-blue-600 text-white px-4 h-9 text-sm font-medium hover:bg-blue-700 shadow-[0_2px_0_rgba(0,0,0,0.05)]">
            ออกจากระบบ
          </button>
        </form>
      @endauth
    </div>
  </div>

  {{-- เมนูมือถือ --}}
  <div class="md:hidden border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 py-2">
      <div class="flex items-center justify-center gap-6 text-sm font-medium">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-blue-700' : 'text-gray-600 hover:text-blue-700' }}">หน้าแรก</a>
        <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.index') ? 'text-blue-700' : 'text-gray-600 hover:text-blue-700' }}">สินค้า</a>
        <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.index') ? 'text-blue-700' : 'text-gray-600 hover:text-blue-700' }}">ตะกร้า</a>
      </div>
    </div>
  </div>
</header>
