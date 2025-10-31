@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

  {{-- หัวข้อ --}}
  <h1 class="text-2xl font-semibold text-gray-900 mb-6">โปรไฟล์ของฉัน</h1>

  {{-- แจ้งสถานะ --}}
  @if (session('status'))
    <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-700 px-4 py-2">
      {{ session('status') }}
    </div>
  @endif
  @if ($errors->any())
    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 text-red-700 px-4 py-2">
      <ul class="list-disc list-inside space-y-1">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- ฟอร์ม --}}
  <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
        class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    @csrf
    @method('PATCH')

    {{-- ซ้าย: รูปโปรไฟล์ --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-6">
      <h2 class="text-sm font-medium text-gray-800 mb-4">รูปโปรไฟล์</h2>

      @php
        $path = auth()->user()->profile_image ?? auth()->user()->avatar_path;
        $avatar = $path ? asset('storage/'.$path) : asset('pic/user.png');
      @endphp

      <div class="flex flex-col items-center gap-3">
        <img id="avatarPreview" src="{{ $avatar }}"
             class="w-32 h-32 rounded-full object-cover border border-gray-300">
        
        {{-- input อัปโหลด --}}
        <label for="profile_image"
               class="w-full text-center cursor-pointer rounded-xl border-2 border-dashed border-gray-300 p-3 text-sm text-gray-600 hover:border-blue-400 transition">
          เลือกรูปภาพใหม่
          <input id="profile_image" name="profile_image" type="file" accept="image/*" class="sr-only">
        </label>

        {{-- ปุ่มลบรูป --}}
        @if($path)
          <button type="submit" name="remove_profile_image" value="1"
                  class="text-xs text-red-600 hover:text-red-800 underline">
            ลบรูปโปรไฟล์
          </button>
        @endif
      </div>
    </div>

    {{-- ขวา: ข้อมูลผู้ใช้ --}}
    <div class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl p-6 space-y-5">

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">ชื่อ</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}"
               class="w-full h-11 rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">อีเมล</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}"
               class="w-full h-11 rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">เบอร์โทร</label>
        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
               class="w-full h-11 rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">ที่อยู่</label>
        <textarea name="address" rows="3"
                  class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('address', $user->address) }}</textarea>
      </div>

      <div class="pt-2 flex gap-3">
        <button type="submit"
                class="inline-flex items-center justify-center h-11 px-5 rounded-xl bg-blue-600 text-white font-medium hover:bg-blue-700">
          บันทึก
        </button>
        <a href="{{ route('home') }}"
           class="inline-flex items-center justify-center h-11 px-5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50">
          กลับหน้าแรก
        </a>
      </div>
    </div>
  </form>
</div>
อ{{-- แถบบรรทัดล่างขวา: ลบบัญชี --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  <div class="pt-6 pb-2 flex justify-end">
    <button type="button" id="openDeleteModal"
            class="text-xs sm:text-sm text-red-600 hover:text-red-800 underline">
      ลบบัญชีผู้ใช้
    </button>
  </div>
</div>


{{-- Preview รูปโปรไฟล์ --}}
<script>
  const input = document.getElementById('profile_image');
  const preview = document.getElementById('avatarPreview');
  input?.addEventListener('change', e => {
    const file = e.target.files?.[0];
    if (!file) return;
    preview.src = URL.createObjectURL(file);
  });
</script>
{{-- 🔴 Modal ยืนยันการลบบัญชี (เล็ก + ไม่เต็มจอ) --}}
<div id="deleteModal"
     class="hidden fixed inset-0 z-[999] bg-black/40 backdrop-blur-sm p-4
            flex items-center justify-center">
  <div id="deleteDialog"
       class="relative w-[88%] max-w-sm sm:max-w-md bg-white rounded-2xl border border-gray-100 shadow-xl
              p-6 text-center opacity-0 scale-95 transition-all duration-150">

    {{-- ปิด --}}
    <button type="button" id="closeDelete"
            class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">✕</button>

    <h3 class="text-lg font-semibold text-gray-900 mb-2">ยืนยันการลบบัญชี</h3>
    <p class="text-sm text-gray-600 mb-4 leading-relaxed">
      การลบนี้เป็นการลบถาวรและไม่สามารถกู้คืนได้<br>โปรดพิมพ์รหัสผ่านเพื่อยืนยัน
    </p>

    <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
      @csrf
      @method('DELETE')
      <input type="password" name="password" required
             class="w-full h-11 rounded-xl border-gray-300 text-center
                    focus:border-red-500 focus:ring-red-500"
             placeholder="รหัสผ่านปัจจุบัน">

      <div class="flex justify-end gap-3 pt-1">
        <button type="button" id="cancelDelete"
                class="px-4 h-10 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50">
          ยกเลิก
        </button>
        <button type="submit"
                class="px-4 h-10 rounded-xl bg-red-600 text-white hover:bg-red-700">
          ยืนยันการลบ
        </button>
      </div>
    </form>
  </div>
</div>

{{-- Script คุม modal --}}
<script>
  const modal   = document.getElementById('deleteModal');
  const dialog  = document.getElementById('deleteDialog');
  const openBtn = document.getElementById('openDeleteModal');
  const closeBtn= document.getElementById('closeDelete');
  const cancel  = document.getElementById('cancelDelete');

  function openModal(){
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
    requestAnimationFrame(()=> dialog.classList.remove('opacity-0','scale-95'));
  }
  function closeModal(){
    dialog.classList.add('opacity-0','scale-95');
    document.body.classList.remove('overflow-hidden');
    setTimeout(()=> modal.classList.add('hidden'), 140);
  }

  openBtn?.addEventListener('click', openModal);
  closeBtn?.addEventListener('click', closeModal);
  cancel?.addEventListener('click', closeModal);
  modal?.addEventListener('click', (e)=>{ if(e.target===modal) closeModal(); });
  window.addEventListener('keydown', (e)=>{ if(e.key==='Escape') closeModal(); });
</script>


@endsection
