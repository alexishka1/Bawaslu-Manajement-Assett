<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemMutasiRuangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'ruangan_asal_id',
        'ruangan_tujuan_id',
        'user_id',
        'tanggal_mutasi',
        'alasan',
    ];

    protected $casts = [
        'tanggal_mutasi' => 'datetime',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function ruanganAsal(): BelongsTo
    {
        return $this->belongsTo(RefRuangan::class, 'ruangan_asal_id');
    }

    public function ruanganTujuan(): BelongsTo
    {
        return $this->belongsTo(RefRuangan::class, 'ruangan_tujuan_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
