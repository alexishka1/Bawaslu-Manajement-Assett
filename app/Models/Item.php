<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
                $item->qr_code = url('/scan/' . $item->kode_bmn);
            }
        });
    }
}
