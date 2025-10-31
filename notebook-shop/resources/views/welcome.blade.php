@extends('layouts.app')

@section('content')
  {{-- HERO SECTION --}}
  <section class="relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20 grid lg:grid-cols-2 gap-10 items-center">
      <div>
        <h1 class="mt-3 text-4xl sm:text-5xl font-anton leading-tight text-blue-700">
          Power Up Your Performance
        </h1>
        <p class="mt-5 text-gray-700 leading-relaxed text-base sm:text-lg">
          ค้นพบแล็ปท็อปและคอมพิวเตอร์ประสิทธิภาพสูง สำหรับการเรียน การทำงาน และการสร้างสรรค์ —
          ยกระดับประสิทธิภาพของคุณด้วยเทคโนโลยีล่าสุด
        </p>
        <div class="mt-8">
          <a href="{{ route('products.index') }}"
             class="inline-flex items-center rounded-full bg-blue-600 text-white px-6 h-11 text-sm hover:bg-blue-700 transition">
             ดูสินค้า
          </a>
        </div>
      </div>

      <div class="relative">
        <img src="{{ asset('pic/msi.png') }}" alt="MSI Laptop"
             class="w-full max-w-2xl mx-auto drop-shadow-xl select-none pointer-events-none">
      </div>
    </div>
  </section>

  {{-- FEATURE SECTION --}}
  <section class="pb-16">
    <div class="text-center mb-10">
      <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
        พาร์ตเนอร์คอมพิวเตอร์ที่คุณไว้ใจได้
      </h2>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid sm:grid-cols-2 lg:grid-cols-3 gap-10">
      <div class="flex flex-col items-center text-center">
        <img src="{{ asset('pic/shopping-cart.png') }}" class="h-16 w-16 mb-3" alt="สั่งซื้อง่าย">
        <h3 class="font-semibold text-lg">สั่งซื้อง่าย</h3>
        <p class="mt-2 text-gray-600 text-sm">
          เลือกรุ่นที่ต้องการและสั่งซื้อออนไลน์ได้ในไม่กี่คลิก
        </p>
      </div>

      <div class="flex flex-col items-center text-center">
        <img src="{{ asset('pic/express-delivery.png') }}" class="h-16 w-16 mb-3" alt="จัดส่งรวดเร็ว">
        <h3 class="font-semibold text-lg">จัดส่งรวดเร็ว</h3>
        <p class="mt-2 text-gray-600 text-sm">
          จัดส่งสินค้าถึงหน้าบ้านของคุณอย่างปลอดภัยและรวดเร็ว
        </p>
      </div>

      <div class="flex flex-col items-center text-center">
        <img src="{{ asset('pic/achievement.png') }}" class="h-16 w-16 mb-3" alt="คุณภาพดีที่สุด">
        <h3 class="font-semibold text-lg">คุณภาพดีที่สุด</h3>
        <p class="mt-2 text-gray-600 text-sm">
          สินค้าของแท้ รับประกันศูนย์ พร้อมบริการหลังการขายที่มั่นใจได้
        </p>
      </div>
    </div>
  </section>

  {{-- ✅ Footer (เฉพาะหน้า Home) --}}
  <footer class="border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10 py-10 grid md:grid-cols-4 gap-8 text-sm">
      <div>
        <div class="flex items-center gap-2">
          <div class="h-6 w-6 rounded-full bg-blue-600"></div>
          <span class="font-semibold">COMP</span>
        </div>
        <p class="mt-3 text-gray-600">
          เราพร้อมช่วยคุณค้นหาคอมพิวเตอร์ที่เหมาะกับการเรียน การทำงาน และการใช้งานทุกประเภท
        </p>
      </div>
      <div>
        <h4 class="font-semibold mb-3">เกี่ยวกับเรา</h4>
        <ul class="space-y-2 text-gray-600">
          <li><a class="hover:text-blue-600" href="#">บริษัท</a></li>
          <li><a class="hover:text-blue-600" href="#">ฟีเจอร์</a></li>
          <li><a class="hover:text-blue-600" href="#">บล็อก</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-semibold mb-3">บริการลูกค้า</h4>
        <ul class="space-y-2 text-gray-600">
          <li><a class="hover:text-blue-600" href="#">คำถามที่พบบ่อย</a></li>
          <li><a class="hover:text-blue-600" href="#">การรับประกัน</a></li>
          <li><a class="hover:text-blue-600" href="#">ติดต่อเรา</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-semibold mb-3">ติดต่อเรา</h4>
        <form class="flex gap-2">
          <input type="email" placeholder="อีเมลของคุณ"
                 class="flex-1 rounded-xl border border-gray-300 px-3 h-10 focus:ring-2 focus:ring-blue-200 focus:border-blue-500">
          <button type="submit"
                  class="rounded-xl bg-blue-600 text-white px-4 h-10 hover:bg-blue-700">
            ส่ง
          </button>
        </form>
      </div>
    </div>
    <div class="text-center text-xs text-gray-500 pb-8">
      © {{ date('Y') }} COMP. สงวนลิขสิทธิ์
    </div>
  </footer>
@endsection
