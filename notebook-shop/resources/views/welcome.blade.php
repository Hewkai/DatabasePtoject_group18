<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name', 'Notebook Shop') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root{--c:#111;--muted:#666;--bg:#fafafa;--card:#fff;--b:#e6e6e6}
    *{box-sizing:border-box} html,body{margin:0}
    body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;background:var(--bg);color:var(--c)}
    header{display:flex;gap:12px;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--b);background:#fff;position:sticky;top:0}
    header h1{margin:0;font-size:18px}
    header nav a, header nav button{color:var(--c);text-decoration:none;padding:8px 10px;border:1px solid var(--b);border-radius:8px;background:#fff;font:inherit;cursor:pointer}
    main{max-width:1100px;margin:20px auto;padding:0 20px}
    .toolbar{display:flex;gap:12px;align-items:center;justify-content:space-between;margin-bottom:16px}
    .toolbar input{flex:1;max-width:420px;padding:10px 12px;border:1px solid var(--b);border-radius:8px}
    .grid{display:grid;grid-template-columns:repeat(1,minmax(0,1fr));gap:16px}
    @media (min-width:640px){.grid{grid-template-columns:repeat(2,1fr)}}
    @media (min-width:960px){.grid{grid-template-columns:repeat(3,1fr)}}
    .card{background:var(--card);border:1px solid var(--b);border-radius:12px;overflow:hidden;display:flex;flex-direction:column}
    .thumb{width:100%;aspect-ratio:16/10;background:#f2f2f2;display:flex;align-items:center;justify-content:center;font-size:12px;color:#999}
    .card-body{padding:14px;display:flex;flex-direction:column;gap:8px}
    .title{font-weight:600}
    .meta{font-size:13px;color:var(--muted)}
    .price{margin-top:4px;font-weight:700}
    .row{display:flex;gap:8px;align-items:center;justify-content:space-between}
    .btn{display:inline-block;padding:8px 10px;border:1px solid var(--b);background:#fff;border-radius:8px;text-decoration:none;color:#111;font-size:14px}
    .badge{display:inline-block;font-size:12px;background:#f3f4f6;border:1px solid var(--b);color:#333;padding:2px 8px;border-radius:999px}
    .empty,.error,.loading{padding:24px;text-align:center;color:var(--muted)}
  </style>
</head>
<body>
<header>
  <h1>🛍️ {{ config('app.name', 'Notebook Shop') }}</h1>

  <nav style="display:flex;gap:12px;align-items:center">
    <a href="{{ route('cart.index') }}">ตะกร้า</a>

    {{-- ผู้ใช้ที่ล็อกอินแล้ว --}}
    @auth
      <a href="{{ route('profile.edit') }}">โปรไฟล์ของฉัน</a>

      {{-- เฉพาะแอดมินเท่านั้นที่เห็น Admin + API --}}
      @if (auth()->user()->is_admin)
        <a href="/admin">Admin</a>
        <a href="/api/products" target="_blank" rel="noopener">API</a>
      @endif

      <form method="POST" action="{{ route('logout') }}" style="display:inline">
        @csrf
        <button type="submit">ออกจากระบบ</button>
      </form>
    @endauth

    {{-- ผู้เยี่ยมชม (ยังไม่ล็อกอิน) --}}
    @guest
      <a href="{{ route('login') }}">เข้าสู่ระบบ</a>
      <a href="{{ route('register') }}">สมัครสมาชิก</a>
    @endguest
  </nav>
</header>

<main>
  <div class="toolbar">
    <input id="q" type="search" placeholder="ค้นหา: รุ่น / ยี่ห้อ / CPU / GPU ...">
    <span class="badge" id="count">—</span>
  </div>

  <div id="loading" class="loading">กำลังโหลดสินค้า…</div>
  <div id="error" class="error" style="display:none"></div>
  <div id="grid" class="grid" style="display:none"></div>
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
           <button class="btn" type="submit">เพิ่มลงตะกร้า</button>
         </form>`
      : `<a class="btn" href="/login">เข้าสู่ระบบเพื่อซื้อ</a>`;

    return `
      <article class="card">
        <a href="${detailUrl}" class="thumb" aria-label="ดู ${brand} ${p.model}">
          ${img ? `<img src="${img}" alt="${brand} ${p.model}" style="width:100%;height:100%;object-fit:cover;">` : 'ไม่มีรูป'}
        </a>
        <div class="card-body">
          <a class="title" href="${detailUrl}">${brand} • ${p.model}</a>
          <div class="meta">CPU: ${cpu || '-'} | RAM: ${ram} | SSD: ${ssd}</div>
          <div class="meta">GPU: ${gpu}</div>
          <div class="row">
            <div class="price">${money(p.price)}</div>
            ${addBtn}
          </div>
        </div>
      </article>
    `;
  }

  function render(list){
    elGrid.innerHTML = list.map(cardHtml).join('');
    elCount.textContent = `${list.length} รายการ`;
    elGrid.style.display = list.length ? 'grid' : 'none';

    if (!list.length){
      elErr.style.display = 'none';
      elLoad.style.display = 'none';
      const empty = document.createElement('div');
      empty.className = 'empty';
      empty.textContent = 'ไม่พบสินค้า';
      elGrid.after(empty);
    } else {
      const next = elGrid.nextElementSibling;
      if (next && next.classList.contains('empty')) next.remove();
    }
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
      elErr.style.display = 'block';
    } finally {
      elLoad.style.display = 'none';
    }
  })();
</script>
</body>
</html>
