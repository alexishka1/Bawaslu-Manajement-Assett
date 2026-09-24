<?php

namespace App\Models;

use App\Services\NomorDokumenService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class BastPengembalianHeader extends Model
{
    use HasFactory;

    protected $table = 'bast_pengembalian_headers';

    protected $fillable = [
        'nomor_bast_pengembalian',
        'tanggal',
        'lokasi',
        'pihak_menyerahkan_tipe',
        'pihak_menyerahkan_nip',
        'pihak_menyerahkan_nama_manual',
        'pihak_menerima_nip',
        'ttd_pihak1_url',
        'ttd_pihak2_url',
        'status_dokumen',
        'dibuat_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function ($header) {
            if (! $header->dibuat_oleh && Auth::check()) {
                $header->dibuat_oleh = Auth::id();
            }

            if ($header->status_dokumen === 'final' && empty($header->nomor_bast_pengembalian)) {
                $header->nomor_bast_pengembalian = NomorDokumenService::generate('BAST_PENGEMBALIAN');
            }
        });

        static::updating(function ($header) {
            if ($header->isDirty('status_dokumen') && $header->status_dokumen === 'final' && empty($header->nomor_bast_pengembalian)) {
                $header->nomor_bast_pengembalian = NomorDokumenService::generate('BAST_PENGEMBALIAN');
            }
        });

        static::saved(function ($header) {
            if ($header->status_dokumen === 'final') {
                foreach ($header->details as $detail) {
                    if ($detail->pemakaianDetail) {
                        $detail->pemakaianDetail->update(['status_item' => 'dikembalikan']);
                    }

                    if ($detail->item) {
                        $targetStatus = in_array($detail->kondisi_saat_kembali, ['Baik', 'Rusak Ringan']) ? 'tersedia' : 'rusak';
                        $detail->item->update(['status' => $targetStatus]);
                    }
                }
            }
        });
    }

    public function details(): HasMany
    {
        return $this->hasMany(BastPengembalianDetail::class, 'pengembalian_header_id');
    }

    public function pihakMenyerahkan(): BelongsTo
    {
        return $this->belongsTo(RefPegawai::class, 'pihak_menyerahkan_nip', 'nip');
    }

    public function pihakMenerima(): BelongsTo
    {
        return $this->belongsTo(RefPejabat::class, 'pihak_menerima_nip', 'nip');
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function getPihakMenyerahkanDisplayAttribute(): string
    {
        if ($this->pihak_menyerahkan_tipe === 'internal') {
            return $this->pihakMenyerahkan ? $this->pihakMenyerahkan->nama.' ('.$this->pihak_menyerahkan_nip.')' : '-';
        }

        return $this->pihak_menyerahkan_nama_manual ?? 'Eksternal';
    }
}
