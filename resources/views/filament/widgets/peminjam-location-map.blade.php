<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center gap-2">
                <span>🗺️</span>
                <span>Peta Lokasi Peminjam Barang</span>
            </div>
        </x-slot>
        <x-slot name="description">
            Titik merah = barang masih dipinjam · Titik hijau = sudah dikembalikan
        </x-slot>

        @php
            $locations = $this->getLocations();
        @endphp

        <div
            wire:ignore
            x-data="peminjamMapWidget(@js($locations))"
            class="space-y-3"
            style="margin-top: 0.5rem;"
        >
            {{-- Map Container --}}
            <div
                x-ref="mapContainer"
                id="peminjam-map"
                class="w-full rounded-xl overflow-hidden shadow-inner border border-gray-200 dark:border-gray-800"
                style="height: 480px; min-height: 480px; z-index: 0; background: #e5e7eb;"
            ></div>

            {{-- Info Banner if empty --}}
            @if (empty($locations))
                <div class="flex items-center justify-between p-3 rounded-lg bg-amber-500/10 border border-amber-500/20 text-amber-700 dark:text-amber-400 text-xs">
                    <div class="flex items-center gap-2">
                        <span class="text-base">📍</span>
                        <span><strong>Belum ada titik peminjaman tersimpan.</strong> Buat dokumen <strong>BAST Pemakaian</strong> baru dan tentukan titik alamat peminjam di peta agar pin tracking muncul di sini.</span>
                    </div>
                    <a
                        href="{{ route('filament.admin.resources.bast-pemakaian-headers.create') }}"
                        class="px-2.5 py-1 rounded bg-amber-600 hover:bg-amber-700 text-white font-medium transition whitespace-nowrap"
                    >
                        + Buat BAST Pemakaian
                    </a>
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
