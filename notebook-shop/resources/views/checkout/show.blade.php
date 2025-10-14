<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <title>ชำระเงิน | {{ config('app.name') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root{--b:#e6e6e6}
    body{font-family:system-ui,Segoe UI,Roboto,Helvetica,Arial,sans-serif;margin:0}
    header{display:flex;gap:12px;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--b)}
    main{max-width:820px;margin:20px auto;padding:0 20px}
    .box{border:1px solid var(--b);border-radius:10px;padding:16px}
    textarea{width:100%;padding:10px;border:1px solid var(--b);border-radius:8px}
    .btn{display:inline-block;padding:10px 12px;border:1px solid var(--b);background:#fff;border-radius:8px;text-decoration:none;color:#111;font-size:14px}
    .row{display:flex;gap:10px;align-items:center;justify-content:space-between;margin-top:14px}
    ul{margin:0;padding-left:18px}
    li{margin:4px 0}
  </style>
</head>
<body>
  <header>
    <a class="btn" href="{{ route('cart.index') }}">← กลับตะกร้า</a>
    <div>ยอดรวม: <strong>{{ number_format($total, 0) }} ฿</strong></div>
  </header>

  <main>
    <div class="box">
      <h3>ที่อยู่จัดส่ง</h3>
      @error('address')
        <div style="color:#c00;margin:8px 0">{{ $message }}</div>
      @enderror
      <form method="post" action="{{ route('checkout.process') }}">
        @csrf
        <textarea name="address" rows="4" placeholder="เช่น บ้านเลขที่/ถนน/ตำบล/อำเภอ/จังหวัด/รหัสไปรษณีย์">{{ old('address') }}</textarea>

        <div class="row">
          <a class="btn" href="{{ route('cart.index') }}">← ย้อนกลับ</a>
          <button type="submit" class="btn">ยืนยันสั่งซื้อ</button>
        </div>
      </form>
    </div>

    <div class="box" style="margin-top:16px">
      <h3>สรุปรายการ</h3>
      <ul>
        @foreach($cart as $row)
          <li>{{ $row['brand'] }} • {{ $row['name'] }} × {{ $row['qty'] }} = {{ number_format($row['price'] * $row['qty'], 0) }} ฿</li>
        @endforeach
      </ul>
      <p><strong>รวมทั้งสิ้น: {{ number_format($total, 0) }} ฿</strong></p>
    </div>
  </main>
</body>
</html>
