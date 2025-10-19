<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10 p-8 bg-white shadow-lg rounded-2xl">
        <h2 class="text-center text-lg font-semibold text-gray-700 mb-6">Member Info Page</h2>

        <!-- Search bar -->
        <form method="GET" action="{{ route('members.index') }}" class="flex justify-center mb-6">
            <div class="relative w-full max-w-lg">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Search" 
                    value="{{ $search ?? '' }}"
                    class="w-full pl-4 pr-10 py-2 rounded-full border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400"
                />
                <button type="submit" class="absolute right-3 top-2 text-gray-400 hover:text-blue-500">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>

        <!-- Member Table -->
        <div class="overflow-hidden rounded-2xl">
            <table class="min-w-full text-left">
                <thead>
                    <tr class="text-gray-500 border-b">
                        <th class="px-6 py-3">ชื่อผู้ใช้</th>
                        <th class="px-6 py-3">อีเมล</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($members as $member)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-3">{{ $member->name }}</td>
                            <td class="px-6 py-3">{{ $member->email }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-gray-400">
                                ไม่พบข้อมูลสมาชิก
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
