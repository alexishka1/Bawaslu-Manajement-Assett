<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'user_id',
        'kondisi_aktual',
        'catatan',
        'foto_bukti',
        'status_validasi',
        'divalidasi_oleh',
        'tanggal_validasi',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_validasi' => 'datetime',
        ];
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'divalidasi_oleh');
    }
}
