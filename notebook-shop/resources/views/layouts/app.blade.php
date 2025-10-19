<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Notebook Shop') }}</title>

    {{-- โหลดไฟล์จาก Vite: Tailwind + JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- สไตล์เสริมเล็กน้อย (จะคงไว้หรือเอาออกก็ได้) --}}
    <style>
        :root{--b:#e6e6e6;--c:#111;--bg:#fafafa}
        *{box-sizing:border-box}
        html,body{margin:0}
        body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;background:var(--bg);color:var(--c)}
        header{display:flex;gap:12px;align-items:center;justify-content:space-between;padding:14px 18px;border-bottom:1px solid var(--b);background:#fff;position:sticky;top:0}
        header a, header button{padding:8px 10px;border:1px solid var(--b);border-radius:8px;background:#fff;text-decoration:none;color:inherit;cursor:pointer}
        main{max-width:960px;margin:22px auto;padding:0 18px}
        .container{min-height:100dvh;display:flex;flex-direction:column}
    </style>
</head>
<body>
<div class="container">
    <header>
        <div>
            <a href="{{ url('/') }}" aria-label="Home">🛍️ {{ config('app.name', 'Notebook Shop') }}</a>
        </div>
        <nav style="display:flex;gap:10px;align-items:center">
            <a href="{{ route('cart.index') }}">ตะกร้า</a>

            @auth
                <a href="{{ route('profile.edit') }}">โปรไฟล์ของฉัน</a>
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}">Admin</a>
                    <a href="/api/products" target="_blank" rel="noopener">API</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit">ออกจากระบบ</button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}">เข้าสู่ระบบ</a>
                <a href="{{ route('register') }}">สมัครสมาชิก</a>
            @endguest
        </nav>
    </header>

    <main>
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </main>
</div>

{{-- สคริปต์เพิ่มเติมจากเพจย่อย (เช่น Chart.js ใน admin.dashboard) --}}
@stack('scripts')
</body>
</html>
