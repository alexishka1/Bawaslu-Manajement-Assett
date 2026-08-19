<?php

namespace App\Services;

use App\Models\ConfigPenomoran;
use Illuminate\Support\Facades\DB;

class NomorDokumenService
{
    /**
     * Generate nomor dokumen otomatis secara atomic (thread-safe).
     *
     * @param string $jenisDokumen
     * @return string
     */
    public static function generate(string $jenisDokumen): string
    {
        $tahun = (int) date('Y');

        return DB::transaction(function () use ($jenisDokumen, $tahun) {
            $config = ConfigPenomoran::where('jenis_dokumen', $jenisDokumen)
                ->where('tahun_berjalan', $tahun)
                ->lockForUpdate()
                ->first();

            if (! $config) {
                $previousConfig = ConfigPenomoran::where('jenis_dokumen', $jenisDokumen)->latest('id')->first();
                $defaultFormat = $previousConfig ? $previousConfig->format_nomor : self::getDefaultFormat($jenisDokumen);

                $config = ConfigPenomoran::create([
                    'jenis_dokumen' => $jenisDokumen,
                    'format_nomor' => $defaultFormat,
                    'counter_terakhir' => 0,
                    'tahun_berjalan' => $tahun,
                ]);

                $config = ConfigPenomoran::where('id', $config->id)->lockForUpdate()->first();
            }

            $config->counter_terakhir += 1;
            $config->save();

            $counterPadded = str_pad((string) $config->counter_terakhir, 3, '0', STR_PAD_LEFT);
            $counterRaw = (string) $config->counter_terakhir;

            $formatted = str_replace(
                ['{counter}', '{counter_raw}', '{tahun}'],
                [$counterPadded, $counterRaw, (string) $tahun],
                $config->format_nomor
            );

            return $formatted;
        });
    }

    /**
     * Default format penomoran jika belum ada di database.
     */
    public static function getDefaultFormat(string $jenisDokumen): string
    {
        return match ($jenisDokumen) {
            'BAST_PEMAKAIAN_KIB' => '{counter}/BAST-KIB/{tahun}',
            'BAST_PEMAKAIAN_NON_KIB' => '{counter}/BAST-NONKIB/{tahun}',
            'BAST_PINJAM_PAKAI' => '{counter}/BAST-PINJAM/{tahun}',
            'BAST_PENGEMBALIAN' => '{counter}/BAST-KEMBALI/{tahun}',
            default => '{counter}/BAST/{tahun}',
        };
    }
}