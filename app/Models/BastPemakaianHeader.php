<?php

namespace App\Models;

use App\Services\NomorDokumenService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class BastPemakaianHeader extends Model
{
    use HasFactory;

    protected $table = 'bast_pemakaian_headers';

    protected $fillable = [
        'nomor_bast',
        'jenis_bast',
        'tanggal_bast',
        'lokasi',
        'pihak_pertama_nip',
        'pihak_kedua_tipe',
        'pihak_kedua_nip',
        'pihak_kedua_nama_manual',
        'alamat_peminjam',
        'latitude',
        'longitude',
        'ttd_pihak1_url',
        'ttd_pihak2_url',
        'status_dokumen',
        'dibuat_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_bast' => 'date',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function ($header) {
            if (! $header->dibuat_oleh && Auth::check()) {
                $header->dibuat_oleh = Auth::id();
            }

            if ($header->status_dokumen === 'final' && empty($header->nomor_bast)) {
                $header->nomor_bast = NomorDokumenService::generate($header->jenis_bast);
            }
        });

        static::updating(function ($header) {
            if ($header->isDirty('status_dokumen') && $header->status_dokumen === 'final' && empty($header->nomor_bast)) {
                $header->nomor_bast = NomorDokumenService::generate($header->jenis_bast);
            }
        });

        static::saved(function ($header) {
            if ($header->status_dokumen === 'final') {
                foreach ($header->details as $detail) {
                    if ($detail->item && $detail->item->status === 'tersedia') {
                        $detail->item->update(['status' => 'terpakai']);
                    }
                }
            }
        });
    }

    public function details(): HasMany
    {
        return $this->hasMany(BastPemakaianDetail::class, 'bast_header_id');
    }

    public function pihakPertama(): BelongsTo
    {
        return $this->belongsTo(RefPejabat::class, 'pihak_pertama_nip', 'nip');
    }

    public function pihakKedua(): BelongsTo
    {
        return $this->belongsTo(RefPegawai::class, 'pihak_kedua_nip', 'nip');
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function getPihakKeduaDisplayAttribute(): string
    {
        if ($this->pihak_kedua_tipe === 'internal') {
            return $this->pihakKedua ? $this->pihakKedua->nama.' ('.$this->pihak_kedua_nip.')' : '-';
        }

        return $this->pihak_kedua_nama_manual ?? 'Eksternal';
    }

    /**
     * Helper: nama peminjam, baik internal (pegawai) maupun eksternal
     */
    public function getNamaPeminjamAttribute(): string
    {
        return $this->pihak_kedua_tipe === 'internal'
            ? ($this->pihakKedua?->nama ?? '-')
            : ($this->pihak_kedua_nama_manual ?? '-');
    }

    /**
     * Cek apakah header ini punya titik lokasi valid
     */
    public function hasLokasi(): bool
    {
        return $this->latitude !== null && $this->longitude !== null;
    }
}
