{{-- resources/views/filament/parts/back-to-overview.blade.php --}}
@php
    // ซ่อนปุ่มเมื่ออยู่หน้า overview ของคุณเอง
    $hide = request()->routeIs('admin.dashboard');
@endphp

@if (! $hide)
    <x-filament::button
        tag="a"
        href="{{ route('admin.dashboard') }}"
        icon="heroicon-o-home"
        class="ml-2"
    >
        Back to Overview
    </x-filament::button>
@endif
