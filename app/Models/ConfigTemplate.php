<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigTemplate extends Model
{
    use HasFactory;

    protected $table = 'config_templates';

    protected $fillable = [
        'jenis_dokumen',
        'nama_template',
        'blade_view',
        'keterangan',
    ];
}