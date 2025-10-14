<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <title>{{ $product->brand?->name }} • {{ $product->model }} | {{ config('app.name') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root{--b:#e6e6e6}
    body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;margin:0}
    header{display:flex;gap:12px;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--b)}
    main{max-width:980px;margin:20px auto;padding:0 20px}
    .wrap{display:grid;grid-template-columns:1fr;gap:20px}
    @media(min-width:900px){.wrap{grid-template-columns:1.2fr 1fr}}
    .img{aspect-ratio:16/10;background:#f5f5f5;display:flex;align-items:center;justify-content:center;border:1px solid var(--b);border-radius:10px;overflow:hidden}
    .box{border:1px solid var(--b);border-radius:10px;padding:16px}
    .title{font-size:22px;font-weight:700}
    .meta{color:#666;margin-top:6px}
    .price{font-size:20px;font-weight:700;margin-top:10px}
    .row{display:flex;gap:8px;align-items:center;margin-top:12px}
    .btn{display:inline-block;padding:10px 12px;border:1px solid var(--b);background:#fff;border-radius:8px;text-decoration:none;color:#111;font-size:14px}
  </style>
</head>
<body>
  <header>
    <div><a href="/" class="btn">← กลับหน้าแรก</a></div>
    <nav>
      @auth
        <a class="btn" href="{{ route('cart.index') }}">ตะกร้า</a>
      @else
        <a class="btn" href="{{ route('login') }}">เข้าสู่ระบบ</a>
      @endauth
    </nav>
  </header>

  <main class="wrap">
    <div class="img">
      @if($product->primaryImage?->url)
        <img src="{{ $product->primaryImage->url }}" alt="{{ $product->brand?->name }} {{ $product->model }}" style="width:100%;height:100%;object-fit:cover">
      @else
        ไม่มีรูป
      @endif
    </div>

    <div class="box">
      <div class="title">{{ $product->brand?->name }} • {{ $product->model }}</div>
      <div class="meta">
        CPU: {{ trim(($product->cpu_brand.' '.$product->cpu_model)) ?: '-' }} |
        RAM: {{ $product->ram_gb ? $product->ram_gb.' GB' : '-' }} |
        SSD: {{ $product->storage_gb ? $product->storage_gb.' GB' : '-' }} |
        GPU: {{ $product->gpu ?: '-' }}
      </div>
      <div class="price">
        @php $price = $product->price ? (float) $product->price : 0; @endphp
        {{ $price ? number_format($price, 0) . ' ฿' : '-' }}
      </div>

      <div class="row">
        @auth
          <form method="post" action="{{ route('cart.add') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button type="submit" class="btn">เพิ่มลงตะกร้า</button>
          </form>
        @else
          <a class="btn" href="{{ route('login') }}">เข้าสู่ระบบเพื่อซื้อ</a>
        @endauth
      </div>
    </div>
  </main>
</body>
</html>
