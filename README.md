# DatabaseProject_group18
สำหรับติดตามการทำงานและประสานงานกัน

Notebook Shop (Laravel 12 + Sail + Filament + Breeze)

ร้านโน้ตบุ๊กตัวอย่าง:

ฝั่ง Public หน้าแรก (/) แสดงรายการสินค้า + ค้นหา

ต้องล็อกอินก่อนกด “เพิ่มลงตะกร้า”, ดูตะกร้า/เช็คเอาต์/คำสั่งซื้อ

แอดมินเข้าหลังบ้านที่ /admin (ใช้ Filament)

ปุ่ม Admin / API จะซ่อนสำหรับผู้ใช้ทั่วไป (เห็นเฉพาะ is_admin = 1)

API สาธารณะตัวอย่าง: /api/products (มี pagination)

.env ให้ดูที่ .env.example

# สั่ง build และขึ้น container ครั้งแรก (อาจใช้เวลาสักพัก)
./vendor/bin/sail up -d  # ถ้ารันไม่ได้ ให้รัน: bash vendor/bin/sail up -d

# ติดตั้ง composer packages ในคอนเทนเนอร์
./vendor/bin/sail composer install

# สร้าง app key (ถ้ายังไม่ถูก set ใน .env)
./vendor/bin/sail artisan key:generate

# สร้าง/อัปเดตตารางฐานข้อมูล + seed ข้อมูลตัวอย่าง
./vendor/bin/sail artisan migrate --seed

# ถ้าต้องการลิงก์ storage สำหรับอัปโหลดรูปโปรไฟล์:
./vendor/bin/sail artisan storage:link

# Breeze
# ติดตั้ง npm packages
./vendor/bin/sail npm install
# เปิด dev server หรือ build
./vendor/bin/sail npm run dev     # โหมด dev
# หรือ
./vendor/bin/sail npm run build   # สร้างไฟล์ production

โครงสร้าง/ฟีเจอร์หลัก

Public

/ : รายการสินค้า (ดึงจาก /api/products) + ค้นหา client-side

คลิกสินค้า → /product/{id}

ต้อง ล็อกอิน ก่อนกด “เพิ่มลงตะกร้า”

Cart / Checkout / Orders

GET /cart → ดูตะกร้า

POST /cart/add / POST /cart/remove

GET /checkout → หน้าชำระเงิน (mock)

POST /checkout → สร้างคำสั่งซื้อ (mock)

GET /orders → คำสั่งซื้อของฉัน

ทั้งหมดต้องล็อกอิน (auth middleware)

Admin (Filament)

/admin : หลังบ้าน (แสดงเฉพาะ is_admin)

มี resource ตัวอย่าง (เช่น Brand, Product … ตามที่ทีมได้ generate ไว้)

API

/api/products?per_page=60 : รายการสินค้า (รวมความสัมพันธ์จำเป็น)

ตอบ JSON + มี header X-Cache-TTL (ถ้า cache)

ตัวอย่างนี้ใช้ Cache Tags → ต้องใช้ Redis (CACHE_STORE=redis)

Profile

/profile : แก้ไขชื่อ อีเมล เบอร์/ที่อยู่ อัปโหลด avatar, เปลี่ยนรหัสผ่าน, ลบบัญชี