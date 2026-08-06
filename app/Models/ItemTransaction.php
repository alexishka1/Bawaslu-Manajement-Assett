<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'item_id',
        'nama_peminjam',
        'divisi',
        'tanggal_pinjam',
        'tanggal_kembali',
        'catatan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
    ];

    /**
     * Get the item that owns the transaction.
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Boot function from Laravel to handle events.
     */
    protected static function booted(): void
    {
        static::created(function (ItemTransaction $transaction) {
            // Ketika dipinjam, ubah status barang jadi terpakai
            if ($transaction->item) {
                $transaction->item->update(['status' => 'terpakai']);
            }
        });

        static::updated(function (ItemTransaction $transaction) {
            // Jika tanggal kembali diisi, ubah status jadi tersedia
            if ($transaction->wasChanged('tanggal_kembali') && !empty($transaction->tanggal_kembali)) {
                if ($transaction->item) {
                    $transaction->item->update(['status' => 'tersedia']);
                }
            }
        });
    }
}
