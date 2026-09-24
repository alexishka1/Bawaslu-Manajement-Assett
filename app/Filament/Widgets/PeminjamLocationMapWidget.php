<?php

namespace App\Filament\Widgets;

use App\Models\BastPemakaianHeader;
use Filament\Widgets\Widget;

class PeminjamLocationMapWidget extends Widget
{
    protected string $view = 'filament.widgets.peminjam-location-map';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 0; // Tampilkan paling atas dashboard

    /**
     * Hanya admin yang boleh lihat widget ini (data alamat = data pribadi)
     */
    public static function canView(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function getLocations(): array
    {
        return BastPemakaianHeader::query()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->with(['pihakKedua', 'details.item'])
            ->latest('tanggal_bast')
            ->get()
            ->map(function (BastPemakaianHeader $bast) {
                $itemNames = $bast->details->pluck('item.nama_barang')->filter()->implode(', ');
                $belumDikembalikan = $bast->details->contains('status_item', 'dipakai');

                return [
                    'lat' => (float) $bast->latitude,
                    'lng' => (float) $bast->longitude,
                    'status' => $belumDikembalikan ? 'dipinjam' : 'dikembalikan',
                    'popup' => [
                        'nama' => $bast->nama_peminjam,
                        'alamat' => $bast->alamat_peminjam ?? '-',
                        'barang' => $itemNames ?: '-',
                        'nomor_bast' => $bast->nomor_bast ?? 'DRAFT',
                        'tanggal' => $bast->tanggal_bast?->format('d F Y') ?? '-',
                        'view_url' => route('filament.admin.resources.bast-pemakaian-headers.view', $bast),
                    ],
                ];
            })
            ->values()
            ->toArray();
    }
}
