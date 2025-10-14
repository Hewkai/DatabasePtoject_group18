<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <title>ตะกร้าสินค้า | {{ config('app.name') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root{--b:#e6e6e6}
    body{font-family:system-ui,Segoe UI,Roboto,Helvetica,Arial,sans-serif;margin:0}
    header{display:flex;gap:12px;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--b)}
    main{max-width:980px;margin:20px auto;padding:0 20px}
    table{width:100%;border-collapse:collapse}
    th,td{padding:10px;border-bottom:1px solid var(--b);text-align:left}
    .right{text-align:right}
    .btn{display:inline-block;padding:8px 10px;border:1px solid var(--b);background:#fff;border-radius:8px;text-decoration:none;color:#111;font-size:14px}
    .row{display:flex;gap:10px;align-items:center;justify-content:space-between;margin:14px 0}
    .flash{padding:10px 12px;border:1px solid var(--b);border-radius:8px;background:#f6ffed}
  </style>
</head>
<body>
  <header>
    <a class="btn" href="/">← เลือกซื้อสินค้าต่อ</a>
    <div>
      <a class="btn" href="{{ route('orders.index') }}">คำสั่งซื้อของฉัน</a>
    </div>
  </header>

  <main>
    @if (session('ok'))
      <div class="flash">{{ session('ok') }}</div>
    @endif
    @if (session('warn'))
      <div class="flash" style="background:#fff7e6">⚠ {{ session('warn') }}</div>
    @endif

    @if (empty($cart))
      <p>ตะกร้าว่าง</p>
    @else
      <table>
        <thead>
          <tr>
            <th>สินค้า</th>
            <th>จำนวน</th>
            <th class="right">ราคา/ชิ้น</th>
            <th class="right">รวม</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($cart as $row)
            <tr>
              <td>{{ $row['brand'] }} • {{ $row['name'] }}</td>
              <td>{{ $row['qty'] }}</td>
              <td class="right">{{ number_format($row['price'], 0) }} ฿</td>
              <td class="right">{{ number_format($row['price'] * $row['qty'], 0) }} ฿</td>
              <td class="right">
                <form method="post" action="{{ route('cart.remove', $row['id']) }}">
                  @csrf
                  <button class="btn" type="submit">ลบ</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th colspan="3" class="right">ยอดรวม</th>
            <th class="right">{{ number_format($total, 0) }} ฿</th>
            <th></th>
          </tr>
        </tfoot>
      </table>

      <div class="row">
        <span></span>
        <a class="btn" href="{{ route('checkout.show') }}">ไปชำระเงิน →</a>
      </div>
    @endif
  </main>
</body>
</html>
