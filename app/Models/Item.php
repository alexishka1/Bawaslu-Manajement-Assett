<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_bmn',
        'nama_barang',
        'kategori',
        'foto',
        'lokasi_simpan',
        'qr_code',
        'status',
        'ref_ruangan_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'string',
        'kategori' => 'string',
    ];

    /**
     * Get the room where this item is currently placed.
     */
    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(RefRuangan::class, 'ref_ruangan_id');
    }

    /**
     * Get all room mutation records for this item.
     */
    public function mutasiRuangans(): HasMany
    {
        return $this->hasMany(ItemMutasiRuangan::class);
    }

    /**
     * Get all transactions for the item.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(ItemTransaction::class);
    }

    /**
     * Get all reports for the item.
     */
    public function reports(): HasMany
    {
        return $this->hasMany(ItemReport::class);
    }

    /**
     * Boot function to auto-generate QR Code value.
     */
    protected static function booted(): void
    {
        static::creating(function (Item $item) {
            // Auto-fill qr_code dengan URL halaman scan
            if (empty($item->qr_code)) {
                $item->qr_code = url('/scan/'.$item->kode_bmn);
            }
        });

        static::updating(function (Item $item) {
            // Sinkronkan qr_code jika kode_bmn berubah
            if ($item->isDirty('kode_bmn') && (empty($item->qr_code) || str_contains($item->qr_code, '/scan/'))) {
                $item->qr_code = url('/scan/'.$item->kode_bmn);
            }
        });
    }
}
