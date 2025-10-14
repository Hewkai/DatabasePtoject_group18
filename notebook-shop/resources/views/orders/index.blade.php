<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <title>คำสั่งซื้อของฉัน | {{ config('app.name') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root{--b:#e6e6e6}
    body{font-family:system-ui,Segoe UI,Roboto,Helvetica,Arial,sans-serif;margin:0}
    header{display:flex;gap:12px;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--b)}
    main{max-width:820px;margin:20px auto;padding:0 20px}
    .box{border:1px solid var(--b);border-radius:10px;padding:16px}
    .btn{display:inline-block;padding:8px 10px;border:1px solid var(--b);background:#fff;border-radius:8px;text-decoration:none;color:#111;font-size:14px}
    ul{margin:0;padding-left:18px}
    li{margin:4px 0}
    .flash{padding:10px 12px;border:1px solid var(--b);border-radius:8px;background:#f6ffed;margin-bottom:12px}
  </style>
</head>
<body>
  <header>
    <a class="btn" href="/">← กลับหน้าแรก</a>
    <a class="btn" href="{{ route('cart.index') }}">ตะกร้า</a>
  </header>

  <main>
    @if (session('ok'))
      <div class="flash">{{ session('ok') }}</div>
    @endif

    @if (!$order)
      <p>ยังไม่มีคำสั่งซื้อ (เดโม่นี้จะแสดงเฉพาะคำสั่งซื้อล่าสุดจาก Session หลัง Checkout)</p>
    @else
      <div class="box">
        <h3>คำสั่งซื้อ #{{ $order['order_no'] }}</h3>
        <p>เวลา: {{ $order['placed_at'] }}</p>
        <p><strong>ที่อยู่จัดส่ง:</strong><br>{!! nl2br(e($order['address'])) !!}</p>
        <h4>สินค้า</h4>
        <ul>
          @foreach($order['items'] as $row)
            <li>{{ $row['brand'] }} • {{ $row['name'] }} × {{ $row['qty'] }} = {{ number_format($row['price'] * $row['qty'], 0) }} ฿</li>
          @endforeach
        </ul>
        <p><strong>ยอดรวม: {{ number_format($order['total'], 0) }} ฿</strong></p>
      </div>
    @endif
  </main>
</body>
</html>
