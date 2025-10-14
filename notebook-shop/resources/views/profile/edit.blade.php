@extends('layouts.app')

@section('title', 'แก้ไขโปรไฟล์')

@section('content')
<div style="max-width:900px;margin:24px auto;font-family:system-ui; padding: 0 16px">
    <h2 style="margin:0 0 16px">โปรไฟล์ของฉัน</h2>

    @if (session('status') === 'profile-updated')
        <div style="padding:10px 12px;border:1px solid #c7f5d9;background:#e9fff1;color:#166534;border-radius:8px;margin-bottom:14px">
            บันทึกโปรไฟล์เรียบร้อย
        </div>
    @endif

    <div style="display:grid;grid-template-columns: 200px 1fr; gap:20px; align-items:flex-start">
        <div style="text-align:center">
            <img src="{{ $user->avatarUrl() }}" alt="avatar" style="width:160px;height:160px;border-radius:50%;object-fit:cover;border:1px solid #e5e7eb">
        </div>

        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data"
              style="display:grid; gap:12px">
            @csrf
            @method('patch')

            <div>
                <label>รูปโปรไฟล์</label><br>
                <input type="file" name="avatar" accept="image/*">
                @error('avatar') <div style="color:#b91c1c">{{ $message }}</div> @enderror
            </div>

            <div>
                <label>ชื่อ</label><br>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                @error('name') <div style="color:#b91c1c">{{ $message }}</div> @enderror
            </div>

            <div>
                <label>อีเมล</label><br>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                @error('email') <div style="color:#b91c1c">{{ $message }}</div> @enderror
            </div>

            <div>
                <label>เบอร์โทร</label><br>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                @error('phone') <div style="color:#b91c1c">{{ $message }}</div> @enderror
            </div>

            <div>
                <label>ที่อยู่</label><br>
                <textarea name="address" rows="3" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">{{ old('address', $user->address) }}</textarea>
                @error('address') <div style="color:#b91c1c">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex; gap:8px">
                <button type="submit" style="padding:10px 14px;border:1px solid #111;border-radius:8px;background:#111;color:#fff">
                    บันทึก
                </button>
                <a href="{{ url('/') }}" style="padding:10px 14px;border:1px solid #e5e7eb;border-radius:8px;background:#fff;text-decoration:none">
                    กลับหน้าแรก
                </a>
            </div>
        </form>
    </div>

    <hr style="margin:24px 0">

    <details>
        <summary style="cursor:pointer">ลบบัญชี</summary>
        <form method="post" action="{{ route('profile.destroy') }}" style="margin-top:12px;display:grid;gap:8px">
            @csrf
            @method('delete')
            <label>ยืนยันรหัสผ่าน</label>
            <input type="password" name="password" style="max-width:360px;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
            @error('password') <div style="color:#b91c1c">{{ $message }}</div> @enderror
            <button type="submit" style="width:max-content;padding:10px 14px;border:1px solid #b91c1c;border-radius:8px;background:#fee2e2;color:#7f1d1d">
                ลบบัญชีถาวร
            </button>
        </form>
    </details>
</div>
@endsection
