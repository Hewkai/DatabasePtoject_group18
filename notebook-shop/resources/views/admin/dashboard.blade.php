<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            <!-- Stats-->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-md text-center">
                    <p class="text-gray-500 mb-2">ยอดรวมการสั่งซื้อ</p>
                    <h2 class="text-4xl font-bold text-gray-800">1,356</h2>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-md text-center">
                    <p class="text-gray-500 mb-2">ยอดรวมวันนี้</p>
                    <h2 class="text-4xl font-bold text-gray-800">12</h2>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-md">
                    <p class="font-semibold text-gray-700 mb-3">Popular Brands</p>
                    <ul class="text-sm space-y-2">
                        <li>1. Asus</li>
                        <li>2. Lenovo</li>
                        <li>3. HP</li>
                    </ul>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-md">
                    <p class="font-semibold text-gray-700 mb-3">สถานะคำสั่งซื้อ</p>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between"><span>ชำระเงินแล้ว</span><span class="text-green-600 font-bold">1356</span></div>
                        <div class="flex justify-between"><span>เตรียมสินค้า</span><span class="text-yellow-500 font-bold">1356</span></div>
                        <div class="flex justify-between"><span>จัดส่งแล้ว</span><span class="text-blue-600 font-bold">1356</span></div>
                    </div>
                </div>
            </div>

<!-- Customer Overview(Chart) -->
<div class="bg-white rounded-2xl shadow-md p-8 flex flex-col lg:flex-row justify-between items-center gap-10">
    <!-- Donut Chart + Total -->
    <div class="flex flex-col items-center w-full lg:w-1/3">
        <div class="relative w-48 h-48">
            <svg class="w-full h-full transform -rotate-90">
                <circle cx="96" cy="96" r="80" stroke="#f0f0f0" stroke-width="16" fill="none"/>
                <circle cx="96" cy="96" r="80" stroke="url(#gradient)" stroke-width="16" stroke-linecap="round"
                    stroke-dasharray="510" stroke-dashoffset="90" fill="none"/>
                <defs>
                    <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#60a5fa"/>
                        <stop offset="100%" stop-color="#86efac"/>
                    </linearGradient>
                </defs>
            </svg>
            <div class="absolute inset-0 flex flex-col justify-center items-center">
                <span class="text-3xl font-bold text-gray-800">82.3%</span>
                <span class="text-gray-500 text-sm">Total</span>
            </div>
        </div>
        <p class="mt-4 text-gray-700 font-semibold text-lg">จำนวนลูกค้า <span class="text-2xl font-bold">1356</span> คน</p>
    </div>

    <!-- Growth Stats -->
    <div class="flex flex-col justify-center space-y-6 text-gray-600 w-full lg:w-1/3">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 flex justify-center items-center rounded-full bg-indigo-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                </svg>
            </div>
            <div>
                <p class="text-xl font-semibold text-indigo-600">+18%</p>
                <p class="text-sm text-gray-500">Daily customers</p>
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 flex justify-center items-center rounded-full bg-green-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <div>
                <p class="text-xl font-semibold text-green-600">+14%</p>
                <p class="text-sm text-gray-500">Weekly new customers</p>
            </div>
        </div>
    </div>

    <!-- Gender Stats -->
    <div class="flex flex-col space-y-6 text-gray-600 w-full lg:w-1/3">
        <div class="flex items-center justify-between border-b pb-3">
            <div class="flex items-center space-x-2">
                <span class="text-pink-400 text-xl">♂</span>
                <span class="text-gray-600 font-medium">เพศชาย</span>
            </div>
            <span class="text-gray-800 font-bold text-lg">1000 คน</span>
        </div>
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span class="text-pink-400 text-xl">♀</span>
                <span class="text-gray-600 font-medium">เพศหญิง</span>
            </div>
            <span class="text-gray-800 font-bold text-lg">1000 คน</span>
        </div>
    </div>
</div>



            <!-- Orders Table Section-->
<div 
    x-data="{
        search: '',
        currentPage: 1,
        perPage: 3,
        orders: [
            { id: 'PDI2949UXLM', item: 'apple', date: '24-09-2022', name: 'Chawi Ammaraporn', payment: 'ชำระเงินสำเร็จ', status: 'เตรียมพัสดุ', price: 279 },
            { id: 'MDI2249UXLM', item: 'apple', date: '24-09-2022', name: 'Chawi Ammaraporn', payment: 'ชำระเงินสำเร็จ', status: 'เตรียมพัสดุ', price: 279 },
            { id: 'KAI2949UXLM', item: 'apple', date: '24-09-2022', name: 'Chawi Ammaraporn', payment: 'ยกเลิกชำระเงิน', status: 'ยกเลิก', price: 279 },
            { id: 'LMI9999ZKLM', item: 'apple', date: '25-09-2022', name: 'John Doe', payment: 'ชำระเงินสำเร็จ', status: 'จัดส่งสำเร็จ', price: 279 },
        ],
        get filteredOrders() {
            let result = this.orders.filter(o =>
                o.id.toLowerCase().includes(this.search.toLowerCase())
            );
            let start = (this.currentPage - 1) * this.perPage;
            return result.slice(start, start + this.perPage);
        },
        get totalPages() {
            return Math.ceil(this.orders.length / this.perPage);
        }
    }"
    class="bg-white p-8 rounded-2xl shadow-md"
>
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-lg font-semibold text-gray-700">ตารางคำสั่งซื้อ</h2>
        <input
            x-model="search"
            type="text"
            placeholder="กรอกรหัสคำสั่งซื้อ"
            class="rounded-full shadow-sm border border-gray-100 px-5 py-2 w-full sm:w-72 focus:ring-2 focus:ring-blue-300"
        />
    </div>

    <table class="min-w-full text-sm">
        <thead>
            <tr class="text-gray-400 border-b">
                <th class="pb-3 text-left">รหัสคำสั่งซื้อ</th>
                <th class="pb-3 text-left">รายการ</th>
                <th class="pb-3 text-left">วันที่</th>
                <th class="pb-3 text-left">ชื่อ</th>
                <th class="pb-3 text-left">การชำระเงิน</th>
                <th class="pb-3 text-left">สถานะ</th>
                <th class="pb-3 text-right">ราคา</th>
            </tr>
        </thead>
        <tbody>
            <template x-for="order in filteredOrders" :key="order.id">
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-3" x-text="order.id"></td>
                    <td x-text="order.item"></td>
                    <td x-text="order.date"></td>
                    <td x-text="order.name"></td>

                    <td>
                        <span 
                            x-text="order.payment"
                            :class="{
                                'px-3 py-1 rounded-full text-xs bg-green-100 text-green-600': order.payment.includes('สำเร็จ'),
                                'px-3 py-1 rounded-full text-xs bg-purple-100 text-purple-600': order.payment.includes('ยกเลิก')
                            }"
                        ></span>
                    </td>

                    <td>
                        <span 
                            x-text="order.status"
                            :class="{
                                'px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700': order.status.includes('เตรียม'),
                                'px-3 py-1 rounded-full text-xs bg-green-100 text-green-700': order.status.includes('จัดส่ง'),
                                'px-3 py-1 rounded-full text-xs bg-pink-100 text-pink-700': order.status.includes('ยกเลิก')
                            }"
                        ></span>
                    </td>

                    <td class="text-right" x-text="order.price + ' ฿'"></td>
                </tr>
            </template>
        </tbody>
    </table>

    <!-- Pagination + Show Results -->
    <div class="mt-8 flex flex-col sm:flex-row justify-between items-center text-sm text-gray-500 gap-4">
        <div class="flex items-center space-x-2">
            <span>Show result:</span>
            <select
                x-model.number="perPage"
                class="border border-gray-200 rounded-lg px-3 py-1 focus:ring-2 focus:ring-blue-300"
            >
                <option value="3">3</option>
                <option value="5">5</option>
                <option value="10">10</option>
            </select>
        </div>

        <div class="flex items-center space-x-2">
            <button 
                @click="if(currentPage>1) currentPage--"
                class="px-2 py-1 rounded-full hover:bg-gray-100"
                :disabled="currentPage===1"
            >‹</button>

            <template x-for="page in totalPages" :key="page">
                <button
                    @click="currentPage = page"
                    class="px-3 py-1 rounded-full"
                    :class="page === currentPage ? 'bg-indigo-500 text-white' : 'bg-gray-100 hover:bg-gray-200'"
                    x-text="page"
                ></button>
            </template>

            <button 
                @click="if(currentPage<totalPages) currentPage++"
                class="px-2 py-1 rounded-full hover:bg-gray-100"
                :disabled="currentPage===totalPages"
            >›</button>
        </div>
    </div>
</div>


        </div>
    </div>
</x-app-layout>
