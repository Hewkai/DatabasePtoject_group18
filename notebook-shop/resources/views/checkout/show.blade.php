<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <title>ชำระเงิน | {{ config('app.name') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- ฟอนต์ Noto Sans Thai --}}
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root{
      --blue:#0B53D0;
      --blue-100:#DCE9FF;
      --line:#E6E6E6;
      --muted:#64748b;
      --text:#0f172a;
      --shadow:0 1px 2px rgba(0,0,0,.04),0 8px 24px -16px rgba(0,0,0,.25);
      --radius:16px;
    }

    *{box-sizing:border-box}
    body{
      margin:0;
      font-family:'Noto Sans Thai', system-ui, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
      color:var(--text);
      background:#fff;
    }
    a{text-decoration:none;color:inherit}

    /* Top bar */
    .topbar{display:flex;align-items:center;justify-content:space-between;
      border-bottom:1px solid var(--line);padding:12px 20px}
    .topbar .total{font-weight:700}

    /* Container */
    .container{max-width:1100px;margin:24px auto;padding:0 20px}
    .grid{display:grid;grid-template-columns:1fr;gap:24px}
    @media (min-width:1024px){.grid{grid-template-columns:1fr 360px}}

    /* Card */
    .card{background:#fff;border:1px solid #f1f5f9;border-radius:var(--radius);box-shadow:var(--shadow)}
    .card-body{padding:18px}
    .h6{font-size:18px;font-weight:700;margin:0 0 8px}
    .muted{color:var(--muted)}

    /* Textarea */
    textarea{width:100%;min-height:140px;padding:12px 14px;border:1px solid #e2e8f0;border-radius:12px;font:inherit;resize:vertical}
    textarea:focus{outline:2px solid var(--blue-100);border-color:var(--blue)}
    .help{font-size:12px;color:var(--muted);margin-top:6px}

    /* Buttons */
    .actions{display:flex;gap:10px;justify-content:flex-end;margin-top:12px}
    .btn{display:inline-flex;align-items:center;justify-content:center;height:40px;padding:0 16px;border-radius:999px;border:1px solid #e2e8f0;background:#fff;font-weight:600;cursor:pointer}
    .btn:hover{background:#f8fafc}
    .btn-primary{background:var(--blue);border-color:var(--blue);color:#fff}
    .btn-primary:hover{filter:brightness(1.05)}

    /* Summary */
    .summary{position:sticky;top:16px}
    .sum-row{display:flex;justify-content:space-between;padding:8px 0;font-size:14px}
    .sum-divider{border-top:1px solid #e2e8f0;margin:12px 0}
    .sum-total{font-weight:800;font-size:18px}
    .sum-card{border:1px solid var(--blue-100)}

    /* List */
    .list{margin:8px 0 0 0;padding-left:18px}
    .list li{margin:6px 0}
    .right{margin-left:auto}

    /* Flash */
    .flash{padding:10px 12px;border:1px solid var(--line);border-radius:12px;background:#f6ffed;margin-bottom:12px}
    .flash.warn{background:#fff7e6}
  </style>
</head>
<body>

  <div class="topbar">
    <a href="{{ route('cart.index') }}" class="btn">← กลับไปตะกร้าสินค้า</a>
    <div class="muted">ยอดรวมทั้งหมด: <span class="total">฿{{ number_format($total ?? 0, 0) }}</span></div>
  </div>

  <div class="container">
    @if (session('ok'))
      <div class="flash">{{ session('ok') }}</div>
    @endif
    @if (session('warn'))
      <div class="flash warn">⚠ {{ session('warn') }}</div>
    @endif

    <div class="grid">
      {{-- ซ้าย: ฟอร์มที่อยู่ --}}
      <section class="card">
        <div class="card-body">
          <h2 class="h6">ที่อยู่จัดส่ง</h2>
          <form method="POST" action="{{ route('checkout.process') }}">
            @csrf
            <textarea name="address" placeholder="เช่น บ้านเลขที่ / ถนน / ตำบล / อำเภอ / จังหวัด / รหัสไปรษณีย์">{{ old('address') }}</textarea>
            <div class="help">กรุณากรอกข้อมูลให้ครบถ้วนเพื่อการจัดส่งที่รวดเร็ว</div>

            <div class="actions">
              <a href="{{ route('cart.index') }}" class="btn">ย้อนกลับ</a>
              <button type="submit" class="btn btn-primary">ยืนยันการสั่งซื้อ</button>
            </div>
          </form>
        </div>
      </section>

      {{-- ขวา: สรุปคำสั่งซื้อ --}}
      <aside class="summary">
        <div class="card sum-card">
          <div class="card-body">
            <h2 class="h6">สรุปรายการสินค้า</h2>

            <ul class="list">
              @foreach(($cart ?? []) as $row)
                <li>
                  • {{ ($row['brand'] ?? '') ? $row['brand'].' • ' : '' }}{{ $row['name'] }}
                  × {{ (int)($row['qty'] ?? 1) }}
                </li>
              @endforeach
            </ul>

            <div class="sum-divider"></div>

            <div class="sum-row">
              <span class="muted">ยอดรวมสินค้า</span>
              <strong>฿{{ number_format($total ?? 0, 0) }}</strong>
            </div>
            <div class="sum-row">
              <span class="muted">ค่าจัดส่ง</span>
              <strong>คำนวณในขั้นตอนถัดไป</strong>
            </div>
            <div class="sum-row">
              <span class="muted">ภาษี (ประมาณการ)</span>
              <strong>฿{{ number_format($tax ?? 0, 0) }}</strong>
            </div>

            <div class="sum-divider"></div>

            <div class="sum-row">
              <span style="font-weight:800">ยอดชำระทั้งหมด</span>
              @php $grand = ($total ?? 0) + ($shipping ?? 0) + ($tax ?? 0); @endphp
              <span class="sum-total">฿{{ number_format($grand, 0) }}</span>
            </div>
          </div>
        </div>
      </aside>
    </div>
  </div>
</body>
</html>
