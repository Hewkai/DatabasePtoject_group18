<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <title>ตะกร้าสินค้า | {{ config('app.name') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- ฟอนต์ Noto Sans Thai --}}
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root{
      --blue:#0B53D0;
      --blue-100:#DCE9FF;
      --text:#0f172a;
      --muted:#64748b;
      --line:#e6e6e6;
      --bg:#ffffff;
      --shadow:0 1px 2px rgba(0,0,0,.04),0 8px 24px -16px rgba(0,0,0,.25);
      --radius:16px;
    }

    /* base */
    *{box-sizing:border-box}
    body{
      font-family:'Noto Sans Thai', system-ui, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
      margin:0;background:#fff;color:var(--text)
    }
    a{color:inherit;text-decoration:none}
    img{display:block;max-width:100%;height:auto}

    /* header (เรียบๆ ไม่ไปยุ่ง navbar หลัก) */
    header{display:flex;gap:12px;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--line)}
    .btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:8px 12px;border:1px solid var(--line);background:#fff;border-radius:999px;color:#111;font-size:14px;line-height:1}
    .btn-primary{background:var(--blue);border-color:var(--blue);color:#fff}
    .btn-primary:hover{filter:brightness(1.05)}
    .btn:hover{background:#f8fafc}

    /* page */
    main{max-width:1100px;margin:24px auto;padding:0 20px}
    h1{font-size:22px;color:var(--blue);margin:0 0 16px}

    /* layout: ซ้ายรายการ / ขวา summary */
    .layout{display:grid;grid-template-columns:1fr;gap:24px}
    @media (min-width: 1024px){
      .layout{grid-template-columns:1fr 360px}
    }

    /* item card */
    .item{background:var(--bg);border:1px solid #f1f5f9;border-radius:var(--radius);box-shadow:var(--shadow)}
    .item-inner{display:flex;gap:20px;align-items:flex-start;padding:18px}
    .thumb{width:160px;height:110px;border:1px solid #eef2f7;border-radius:14px;object-fit:cover;background:#f8fafc}
    .title{font-size:16px;font-weight:700;margin:0;color:#0b1220}
    .meta{font-size:13px;color:var(--muted);margin-top:2px}

    .price{font-size:18px;font-weight:700;margin-top:10px}

    .item-footer{display:flex;justify-content:flex-end;padding:0 18px 14px}
    .link-remove{font-size:13px;color:#94a3b8;background:none;border:0;cursor:pointer}
    .link-remove:hover{color:#ef4444}

    /* summary */
    .sum{background:#fff;border:1px solid var(--blue-100);border-radius:var(--radius);box-shadow:var(--shadow)}
    .sum-in{padding:18px}
    .sum h2{margin:0 0 12px;font-size:15px;font-weight:700}
    .row{display:flex;align-items:center;justify-content:space-between;padding:9px 0;font-size:14px}
    .row .muted{color:var(--muted)}
    .divider{border-top:1px solid #e2e8f0;margin:12px 0}
    .total{font-weight:800;font-size:18px}

    /* alert */
    .flash{padding:10px 12px;border:1px solid var(--line);border-radius:12px;background:#f6ffed;margin-bottom:12px}
    .flash.warn{background:#fff7e6}
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
    <h1>ตะกร้าสินค้า</h1>

    @if (session('ok'))
      <div class="flash">{{ session('ok') }}</div>
    @endif
    @if (session('warn'))
      <div class="flash warn">⚠ {{ session('warn') }}</div>
    @endif

    @php
      $cart = $cart ?? [];
      $subTotal = $total ?? 0;
      $shipping = $shipping ?? 0;
      $tax = $tax ?? 0;
      $grandTotal = ($grandTotal ?? null) ?? ($subTotal + $shipping + $tax);
    @endphp

    @if (empty($cart))
      <p>ตะกร้าว่าง</p>
    @else
      <div class="layout">
        <!-- ซ้าย: รายการสินค้าแบบการ์ด -->
        <section>
          @foreach($cart as $row)
            <article class="item">
              <div class="item-inner">
                <img class="thumb" src="{{ $row['options']['image'] ?? asset('images/placeholder.png') }}" alt="สินค้า">

                <div style="flex:1">
                  <div style="display:flex;justify-content:space-between;gap:12px">
                    <div>
                      <h3 class="title">
                        {{ ($row['brand'] ?? '') ? $row['brand'].' • ' : '' }}{{ $row['name'] }}
                      </h3>
                      @if(!empty($row['options']['variant']))
                        <div class="meta">{{ $row['options']['variant'] }}</div>
                      @endif
                    </div>
                  </div>

                  <!-- ราคา (ไม่มีปุ่มเพิ่ม/ลด และไม่แสดงค่าส่งในกรอบสินค้า) -->
                  <div style="display:flex;align-items:center;gap:10px;margin-top:8px">
                    <div class="price">฿{{ number_format($row['price'],2) }}</div>
                    <div class="meta">× {{ (int)$row['qty'] }} ชิ้น</div>
                    <div class="meta" style="margin-left:auto">รวม: ฿{{ number_format($row['price'] * $row['qty'], 2) }}</div>
                  </div>
                </div>
              </div>

              <div class="item-footer">
                <form method="post" action="{{ route('cart.remove', $row['id']) }}">
                  @csrf
                  <button type="submit" class="link-remove">ลบสินค้า</button>
                </form>
              </div>
            </article>
          @endforeach
        </section>

        <!-- ขวา: สรุปคำสั่งซื้อ -->
        <aside class="sum">
          <div class="sum-in">
            <h2>สรุปคำสั่งซื้อ</h2>

            <div class="row">
              <span class="muted">ยอดรวมสินค้า:</span>
              <strong>฿{{ number_format($subTotal, 2) }}</strong>
            </div>
            <div class="row">
              <span class="muted">ค่าจัดส่ง:</span>
              <strong>คำนวณในขั้นตอนถัดไป</strong>
            </div>
            <div class="row">
              <span class="muted">ภาษี (ประมาณการ):</span>
              <strong>฿{{ number_format($tax, 2) }}</strong>
            </div>

            <div class="divider"></div>

            <div class="row">
              <span style="font-weight:800;letter-spacing:.2px">ยอดชำระทั้งหมด:</span>
              <span class="total">฿{{ number_format($grandTotal, 2) }}</span>
            </div>

            <div class="row" style="padding-top:12px">
              <a class="btn btn-primary" style="width:100%;height:40px" href="{{ route('checkout.show') }}">
                ดำเนินการชำระเงิน
              </a>
            </div>
          </div>
        </aside>
      </div>
    @endif
  </main>
</body>
</html>
