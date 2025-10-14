<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * แสดงฟอร์มแก้ไขโปรไฟล์
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * อัปเดตโปรไฟล์ (ชื่อ, อีเมล, เบอร์, ที่อยู่, รูปโปรไฟล์)
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name'    => ['required','string','max:255'],
            'email'   => ['required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
            'phone'   => ['nullable','string','max:50'],
            'address' => ['nullable','string','max:2000'],
            'avatar'  => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'], // <= 2MB
            'remove_avatar' => ['nullable','boolean'],
        ]);

        // ถ้าเปลี่ยนอีเมล -> รีเซ็ตการยืนยัน
        if ($user->email !== $data['email']) {
            $user->email_verified_at = null;
        }

        // อัปโหลด/ลบ รูปโปรไฟล์
        if (!empty($data['remove_avatar'])) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $user->avatar_path = null;
        } elseif ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            // ลบไฟล์เก่าถ้ามี
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $path = $request->file('avatar')->store('avatars', 'public'); // storage/app/public/avatars/xxx
            $user->avatar_path = $path;
        }

        // อัปเดตฟิลด์อื่น ๆ
        $user->name    = $data['name'];
        $user->email   = $data['email'];
        $user->phone   = $data['phone']   ?? null;
        $user->address = $data['address'] ?? null;

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'บันทึกโปรไฟล์เรียบร้อย');
    }

    /**
     * เปลี่ยนรหัสผ่าน
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required','current_password'],
            'password'         => ['required','confirmed','min:8'],
        ]);

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('status', 'เปลี่ยนรหัสผ่านเรียบร้อย');
    }

    /**
     * ลบบัญชีผู้ใช้
     */
    public function destroy(Request $request)
    {
        $request->validate(['password' => ['required','current_password']]);

        $user = $request->user();

        Auth::logout();

        // ลบรูปเก่าหากมี
        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'ลบบัญชีเรียบร้อย');
    }
}
