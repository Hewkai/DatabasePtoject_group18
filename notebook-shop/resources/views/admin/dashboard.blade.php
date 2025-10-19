@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
  {{-- Top Bar --}}
  <div class="border-b bg-white">
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8 flex items-center justify-between">
      <h1 class="text-2xl font-semibold">Admin Dashboard</h1>
      <div class="text-sm text-gray-500">Welcome, {{ auth()->user()->name }}</div>
    </div>
  </div>

  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-6">
    {{-- Sidebar --}}
    <aside class="lg:col-span-3">
      <div class="bg-white rounded-2xl shadow p-4 space-y-2">
        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg font-medium bg-gray-100">Overview</a>
        <a href="{{ url('/admin/products') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">Products</a>
        <a href="{{ url('/admin/categories') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">Categories</a>
        <a href="{{ url('/admin/brands') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">Brands</a>
        <a href="{{ url('/admin/users') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">Users</a>
      </div>
    </aside>

    {{-- Main --}}
    <main class="lg:col-span-9 space-y-6">
      {{-- Metric Cards --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl shadow p-5">
          <div class="text-sm text-gray-500">Users</div>
          <div class="mt-2 text-3xl font-bold">{{ number_format($metrics['users']) }}</div>
        </div>
        <div class="bg-white rounded-2xl shadow p-5">
          <div class="text-sm text-gray-500">Products</div>
          <div class="mt-2 text-3xl font-bold">{{ number_format($metrics['products']) }}</div>
        </div>
        <div class="bg-white rounded-2xl shadow p-5">
          <div class="text-sm text-gray-500">Categories</div>
          <div class="mt-2 text-3xl font-bold">{{ number_format($metrics['categories']) }}</div>
        </div>
        <div class="bg-white rounded-2xl shadow p-5">
          <div class="text-sm text-gray-500">Brands</div>
          <div class="mt-2 text-3xl font-bold">{{ number_format($metrics['brands']) }}</div>
        </div>
      </div>

      {{-- Chart + Table --}}
      <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
        <div class="bg-white rounded-2xl shadow p-5">
          <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold">Products by Category</h2>
          </div>
          <canvas id="categoryChart" height="120"></canvas>
        </div>

        <div class="bg-white rounded-2xl shadow p-5">
          <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold">Latest Products</h2>
            <a href="{{ url('/admin/products') }}" class="text-sm text-blue-600 hover:underline">View all</a>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
              <thead class="text-gray-500">
                <tr>
                  <th class="py-2">#</th>
                  <th class="py-2">Name</th>
                  <th class="py-2">Price</th>
                  <th class="py-2">Created</th>
                </tr>
              </thead>
              <tbody class="divide-y">
                @forelse($latestProducts as $p)
                  <tr class="hover:bg-gray-50">
                    <td class="py-2">{{ $p->id }}</td>
                    <td class="py-2 font-medium">{{ $p->name }}</td>
                    <td class="py-2">{{ number_format($p->price, 2) }}</td>
                    <td class="py-2">{{ $p->created_at?->format('Y-m-d') }}</td>
                  </tr>
                @empty
                  <tr><td colspan="4" class="py-4 text-center text-gray-400">No data</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const byCategory = @json($byCategory->map(fn($c)=>['name'=>$c->name,'count'=>$c->products_count]));
  const labels = byCategory.map(i => i.name);
  const data = byCategory.map(i => i.count);
  const ctx = document.getElementById('categoryChart');
  if (ctx && labels.length) {
    new Chart(ctx, {
      type: 'bar',
      data: { labels, datasets: [{ label: 'Products', data }] },
      options: { responsive: true, plugins: { legend: { display:false } }, scales:{ y:{ beginAtZero:true } } }
    });
  }
</script>
@endpush
