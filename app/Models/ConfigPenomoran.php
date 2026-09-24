<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigPenomoran extends Model
{
    use HasFactory;

    protected $table = 'config_penomorans';

    protected $fillable = [
        'jenis_dokumen',
        'format_nomor',
        'counter_terakhir',
        'tahun_berjalan',
    ];

    protected function casts(): array
    {
        return [
            'counter_terakhir' => 'integer',
            'tahun_berjalan' => 'integer',
        ];
    }
}
