<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RefRuangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_ruangan',
        'nama_ruangan',
        'lantai',
        'gedung',
        'penanggung_jawab',
        'nip_penanggung_jawab',
        'keterangan',
    ];

    /**
     * Get all items physically located in this room.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'ref_ruangan_id');
    }

    /**
     * Get all mutation history records where this room is the destination.
     */
    public function mutasiMasuk(): HasMany
    {
        return $this->hasMany(ItemMutasiRuangan::class, 'ruangan_tujuan_id');
    }

    /**
     * Get all mutation history records where this room is the origin.
     */
    public function mutasiKeluar(): HasMany
    {
        return $this->hasMany(ItemMutasiRuangan::class, 'ruangan_asal_id');
    }

    /**
     * Get QR Code target URL for this room.
     */
    public function getQrUrlAttribute(): string
    {
        return url('/scan/ruangan/'.$this->kode_ruangan);
    }
}
