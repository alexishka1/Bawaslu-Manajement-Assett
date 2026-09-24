<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BastPengembalianDetail extends Model
{
    use HasFactory;

    protected $table = 'bast_pengembalian_details';

    protected $fillable = [
        'pengembalian_header_id',
        'bast_pemakaian_detail_id',
        'item_id',
        'kondisi_saat_kembali',
        'catatan_kerusakan',
    ];

    protected static function booted(): void
    {
        static::creating(function ($detail) {
            if (empty($detail->item_id) && $detail->bast_pemakaian_detail_id) {
                $pemakaian = BastPemakaianDetail::find($detail->bast_pemakaian_detail_id);
                if ($pemakaian) {
                    $detail->item_id = $pemakaian->item_id;
                }
            }
        });

        static::saved(function ($detail) {
            if ($detail->header && $detail->header->status_dokumen === 'final') {
                if ($detail->pemakaianDetail) {
                    $detail->pemakaianDetail->update(['status_item' => 'dikembalikan']);
                }

                if ($detail->item) {
                    $targetStatus = in_array($detail->kondisi_saat_kembali, ['Baik', 'Rusak Ringan']) ? 'tersedia' : 'rusak';
                    $detail->item->update(['status' => $targetStatus]);
                }
            }
        });
    }

    public function header(): BelongsTo
    {
        return $this->belongsTo(BastPengembalianHeader::class, 'pengembalian_header_id');
    }

    public function pemakaianDetail(): BelongsTo
    {
        return $this->belongsTo(BastPemakaianDetail::class, 'bast_pemakaian_detail_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
