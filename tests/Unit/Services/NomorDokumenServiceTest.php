<?php

namespace Tests\Unit\Services;

use App\Models\ConfigPenomoran;
use App\Services\NomorDokumenService;
use Tests\TestCase;

class NomorDokumenServiceTest extends TestCase
{
    public function test_generate_creates_formatted_number_with_padding(): void
    {
        $nomor1 = NomorDokumenService::generate('BAST_PEMAKAIAN_KIB');
        $nomor2 = NomorDokumenService::generate('BAST_PEMAKAIAN_KIB');

        $tahun = date('Y');
        $this->assertEquals("001/BAST-KIB/{$tahun}", $nomor1);
        $this->assertEquals("002/BAST-KIB/{$tahun}", $nomor2);

        $config = ConfigPenomoran::where('jenis_dokumen', 'BAST_PEMAKAIAN_KIB')->first();
        $this->assertEquals(2, $config->counter_terakhir);
    }

    public function test_different_document_types_have_separate_counters(): void
    {
        $kib = NomorDokumenService::generate('BAST_PEMAKAIAN_KIB');
        $nonKib = NomorDokumenService::generate('BAST_PEMAKAIAN_NON_KIB');
        $pengembalian = NomorDokumenService::generate('BAST_PENGEMBALIAN');

        $tahun = date('Y');
        $this->assertStringContainsString("001/BAST-KIB/{$tahun}", $kib);
        $this->assertStringContainsString("001/BAST-NONKIB/{$tahun}", $nonKib);
        $this->assertStringContainsString("001/BAST-KEMBALI/{$tahun}", $pengembalian);
    }
}
