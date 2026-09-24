<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BastPemakaianDetail extends Model
{
    use HasFactory;

    protected $table = 'bast_pemakaian_details';

    protected $attributes = [
        'status_item' => 'dipakai',
    ];

    protected $fillable = [
        'bast_header_id',
        'item_id',
        'kondisi_saat_diserahkan',
        'status_item',
    ];

    protected static function booted(): void
    {
        static::saved(function ($detail) {
            if ($detail->header && $detail->header->status_dokumen === 'final' && ($detail->status_item ?? 'dipakai') === 'dipakai') {
                if ($detail->item && $detail->item->status === 'tersedia') {
                    $detail->item->update(['status' => 'terpakai']);
                }
            }
        });
    }

    public function header(): BelongsTo
    {
        return $this->belongsTo(BastPemakaianHeader::class, 'bast_header_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
