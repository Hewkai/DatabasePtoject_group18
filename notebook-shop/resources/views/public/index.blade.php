@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
  <h1 class="text-3xl font-bold mb-8">สินค้า</h1>

  {{-- กล่องค้นหา --}}
  <div class="flex items-center gap-3 mb-8">
    <input id="q" type="search"
           placeholder="ค้นหา: รุ่น / ยี่ห้อ / CPU / GPU ..."
           class="flex-1 border border-gray-300 rounded-xl px-4 h-11 focus:ring-2 focus:ring-blue-200 focus:border-blue-500" />
    <span class="text-sm text-gray-600" id="count">—</span>
  </div>

  {{-- สถานะโหลด / error --}}
  <div id="loading" class="text-gray-500 text-center py-10">กำลังโหลดสินค้า…</div>
  <div id="error" class="text-red-500 text-center py-10 hidden"></div>
  <div id="grid" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 hidden"></div>
</main>

<script>
  const elGrid   = document.getElementById('grid');
  const elLoad   = document.getElementById('loading');
  const elErr    = document.getElementById('error');
  const elQ      = document.getElementById('q');
  const elCount  = document.getElementById('count');
  const CSRF     = @json(csrf_token());
  const LOGGED_IN = @json(auth()->check());
  let ALL = [];

  function money(n){
    if(n === null || n === undefined || n === '') return '-';
    const num = Number(n);
    if (Number.isNaN(num)) return String(n);
    return num.toLocaleString('th-TH', { style: 'currency', currency: 'THB', maximumFractionDigits: 0 });
  }

  function cardHtml(p){
    const brand = p.brand?.name ?? '-';
    const cpu   = [p.cpu_brand,p.cpu_model].filter(Boolean).join(' ');
    const ram   = p.ram_gb ? `${p.ram_gb} GB` : '-';
    const ssd   = p.storage_gb ? `${p.storage_gb} GB` : '-';
    const gpu   = p.gpu ?? '-';
    const img   = p.primary_image?.url ?? null;
    const detailUrl = `/product/${p.id}`;

    const addBtn = LOGGED_IN
      ? `<form method="post" action="/cart/add" style="margin:0">
           <input type="hidden" name="_token" value="${CSRF}">
           <input type="hidden" name="product_id" value="${p.id}">
           <button class="inline-flex items-center justify-center rounded-full bg-blue-600 text-white px-4 h-9 text-sm hover:bg-blue-700 transition">
             เพิ่มลงตะกร้า
           </button>
         </form>`
      : `<a class="inline-flex items-center justify-center rounded-full border border-gray-300 px-4 h-9 text-sm hover:bg-gray-50 transition" href="/login">
           เข้าสู่ระบบเพื่อซื้อ
         </a>`;

    return `
      <article class="border rounded-xl shadow-sm hover:shadow-md transition overflow-hidden bg-white flex flex-col">
        <a href="${detailUrl}" class="block bg-gray-100 aspect-[16/10]">
          ${img ? `<img src="${img}" alt="${brand} ${p.model}" class="w-full h-full object-cover">` : 'ไม่มีรูป'}
        </a>
        <div class="p-4 flex flex-col gap-2">
          <a class="font-semibold text-lg text-gray-900 hover:text-blue-600" href="${detailUrl}">
            ${brand} • ${p.model}
          </a>
          <div class="text-sm text-gray-600">CPU: ${cpu || '-'} | RAM: ${ram} | SSD: ${ssd}</div>
          <div class="text-sm text-gray-600">GPU: ${gpu}</div>
          <div class="flex items-center justify-between mt-2">
            <div class="font-bold text-blue-700">${money(p.price)}</div>
            ${addBtn}
          </div>
        </div>
      </article>
    `;
  }

  function render(list){
    elGrid.innerHTML = list.map(cardHtml).join('');
    elCount.textContent = `${list.length} รายการ`;
    elGrid.classList.toggle('hidden', !list.length);
    elLoad.classList.add('hidden');
    elErr.classList.add('hidden');
  }

  function filter(keyword){
    const q = keyword.trim().toLowerCase();
    if (!q) return render(ALL);
    const out = ALL.filter(p => {
      const brand = (p.brand?.name ?? '').toLowerCase();
      return [
        String(p.id),
        p.model ?? '',
        p.cpu_brand ?? '',
        p.cpu_model ?? '',
        p.gpu ?? '',
        brand,
      ].join(' ').toLowerCase().includes(q);
    });
    render(out);
  }

  elQ.addEventListener('input', (e)=> filter(e.target.value));

  (async () => {
    try {
      const res = await fetch('/api/products?per_page=60', { headers:{ Accept:'application/json' }});
      if(!res.ok) throw new Error(`HTTP ${res.status}`);
      const json = await res.json();
      const items = Array.isArray(json.data) ? json.data : Array.isArray(json) ? json : [];
      ALL = items;
      render(ALL);
    } catch (e){
      elErr.textContent = 'โหลดข้อมูลไม่สำเร็จ: ' + (e?.message ?? e);
      elErr.classList.remove('hidden');
    } finally {
      elLoad.classList.add('hidden');
    }
  })();
</script>
@endsection
