<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
<<<<<<< Updated upstream
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
=======
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ชำระเงิน | {{ config('app.name','Notebook Shop') }}</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-white antialiased">
  @includeIf('layouts.navigation')

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 flex items-center justify-between">
      <div>
        <a href="{{ route('cart.index') }}"
           class="inline-flex items-center gap-2 text-gray-600 hover:text-blue-600 transition mb-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          กลับไปตะกร้า
        </a>
        <h1 class="text-2xl font-bold text-blue-600">ชำระเงิน</h1>
      </div>
      <div class="text-right">
        <p class="text-sm text-gray-600">ยอดรวม</p>
        <p class="text-2xl font-bold text-gray-900">{{ number_format($total ?? 0,0) }} ฿</p>
      </div>
    </div>

    @if (session('status'))
      <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4">
        {{ session('status') }}
      </div>
    @endif
    @if ($errors->any())
      <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6">
        <b>กรุณาตรวจสอบข้อมูล:</b>
        <ul class="list-disc pl-5 mt-2 space-y-1">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('checkout.process') }}">
      @csrf
      <div class="grid lg:grid-cols-5 gap-6">
        {{-- ซ้าย: รายการสินค้า + ที่อยู่ --}}
        <div class="lg:col-span-3 space-y-6">
          {{-- รายการสินค้า (มาจาก CartController->checkoutShow เป็น $items) --}}
          <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">รายการสินค้า</h2>

            @php $items = $items ?? []; @endphp

            @if (empty($items))
              <p class="text-gray-500">ตะกร้าของคุณว่างเปล่า</p>
            @else
              <div class="space-y-4">
                @foreach ($items as $row)
                  <div class="flex gap-4">
                    <div class="w-24 h-24 bg-gray-50 rounded-xl flex items-center justify-center overflow-hidden">
                      @if(!empty($row['image_url']))
                        <img src="{{ $row['image_url'] }}" alt="{{ $row['name'] }}" class="w-full h-full object-contain p-2">
                      @else
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                      @endif
                    </div>

                    <div class="flex-1 min-w-0">
                      <div class="font-bold text-gray-900 truncate">
                        {{ ($row['brand'] ?? '-') . ' • ' . ($row['name'] ?? ('#'.$row['product_id'])) }}
                      </div>
                      <div class="text-sm text-gray-600 mt-1">
                        จำนวน: <b class="text-gray-900">{{ $row['qty'] ?? 1 }}</b>
                      </div>
                      <div class="text-sm text-gray-600">
                        ราคา/ชิ้น: <b class="text-gray-900">{{ number_format($row['price'] ?? 0,0) }} ฿</b>
                      </div>
                      <div class="mt-1">
                        รวม: <b class="text-blue-600">
                          {{ number_format(($row['price'] ?? 0) * ($row['qty'] ?? 1),0) }} ฿
                        </b>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif
          </div>

          {{-- ที่อยู่จัดส่ง --}}
          <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">ที่อยู่จัดส่ง</h2>

            <div class="grid sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm text-gray-700 mb-1">ชื่อ-นามสกุล</label>
                <input type="text" name="shipping_name"
                       value="{{ old('shipping_name', auth()->user()->name ?? '') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl" required>
              </div>
              <div>
                <label class="block text-sm text-gray-700 mb-1">เบอร์โทร</label>
                <input type="text" name="shipping_phone"
                       value="{{ old('shipping_phone') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl" required>
              </div>
            </div>

            <div class="mt-4">
              <label class="block text-sm text-gray-700 mb-1">ที่อยู่</label>
              <textarea name="shipping_address" rows="4" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl resize-none"
                        placeholder="บ้านเลขที่ / ถนน / แขวง/ตำบล / เขต/อำเภอ / จังหวัด / รหัสไปรษณีย์">{{ old('shipping_address', auth()->user()->address ?? '') }}</textarea>
            </div>
          </div>
        </div>

        {{-- ขวา: สรุปยอด + วิธีชำระเงิน --}}
        <div class="lg:col-span-2 space-y-6">
          <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">สรุปยอด</h2>
            <div class="space-y-2 text-sm">
              @foreach(($items ?? []) as $row)
                <div class="flex justify-between">
                  <span class="text-gray-600">
                    {{ ($row['brand'] ?? '-') }} • {{ $row['name'] ?? ('#'.$row['product_id']) }} × {{ $row['qty'] ?? 1 }}
                  </span>
                  <span class="font-semibold text-gray-900">
                    {{ number_format(($row['price'] ?? 0) * ($row['qty'] ?? 1),0) }} ฿
                  </span>
                </div>
              @endforeach
              <div class="border-t border-gray-200 pt-3 mt-3 flex justify-between">
                <span class="font-semibold text-gray-900">รวมทั้งหมด</span>
                <span class="text-lg font-bold text-gray-900">{{ number_format($total ?? 0,0) }} ฿</span>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-base font-bold text-gray-900 mb-3">วิธีชำระเงิน</h2>

            <label class="flex items-center gap-3 bg-gray-50 rounded-xl p-4 cursor-pointer">
              <input type="radio" name="payment_method" value="cod"
                     class="w-4 h-4" {{ old('payment_method','cod')=='cod' ? 'checked' : '' }}>
              <div class="flex-1">
                <div class="text-sm font-medium text-gray-800">ชำระปลายทาง (COD)</div>
                <div class="text-xs text-gray-500">ชำระเมื่อได้รับสินค้า</div>
              </div>
            </label>

            <label class="mt-2 flex items-center gap-3 bg-gray-50 rounded-xl p-4 cursor-pointer">
              <input type="radio" name="payment_method" value="transfer"
                     class="w-4 h-4" {{ old('payment_method')=='transfer' ? 'checked' : '' }}>
              <div class="flex-1">
                <div class="text-sm font-medium text-gray-800">โอนเงิน</div>
                <div class="text-xs text-gray-500">อัปโหลดสลิปหลังสั่งซื้อได้ภายหลัง</div>
              </div>
            </label>

            <button type="submit"
                    class="w-full mt-4 bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition">
              ยืนยันสั่งซื้อ
            </button>
          </div>

          <a href="{{ route('cart.index') }}"
             class="inline-flex items-center justify-center gap-2 px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition">
            กลับไปตะกร้า
          </a>
        </div>
      </div>
    </form>
  </div>
>>>>>>> Stashed changes
</body>
</html>
