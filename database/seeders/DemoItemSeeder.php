<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\RefRuangan;
use Illuminate\Database\Seeder;

class DemoItemSeeder extends Seeder
{
    public function run(): void
    {
        $ruangans = RefRuangan::pluck('id', 'kode_ruangan')->toArray();
        $defaultRuanganId = RefRuangan::first()?->id;

        $items = [
            [
                'kode_bmn' => 'BMN-2026-001',
                'nama_barang' => 'Laptop Lenovo ThinkPad E14',
                'kategori' => 'Elektronik',
                'lokasi_simpan' => 'Ruang IT',
                'status' => 'tersedia',
                'ref_ruangan_id' => $ruangans['R-204'] ?? $defaultRuanganId,
            ],
            [
                'kode_bmn' => 'BMN-2026-002',
                'nama_barang' => 'Proyektor Epson EB-X06',
                'kategori' => 'Elektronik',
                'lokasi_simpan' => 'Ruang Rapat Utama',
                'status' => 'terpakai',
                'ref_ruangan_id' => $ruangans['R-101'] ?? $defaultRuanganId,
            ],
            [
                'kode_bmn' => 'BMN-2026-003',
                'nama_barang' => 'Kamera DSLR Canon EOS 90D',
                'kategori' => 'Elektronik',
                'lokasi_simpan' => 'Divisi Humas',
                'status' => 'tersedia',
                'ref_ruangan_id' => $ruangans['R-203'] ?? $defaultRuanganId,
            ],
            [
                'kode_bmn' => 'BMN-2026-004',
                'nama_barang' => 'Kursi Kerja Ergonomis',
                'kategori' => 'Mebel',
                'lokasi_simpan' => 'Ruang Staff',
                'status' => 'tersedia',
                'ref_ruangan_id' => $ruangans['R-203'] ?? $defaultRuanganId,
            ],
            [
                'kode_bmn' => 'BMN-2026-005',
                'nama_barang' => 'Meja Rapat Lipat',
                'kategori' => 'Mebel',
                'lokasi_simpan' => 'Gudang',
                'status' => 'servis',
                'ref_ruangan_id' => $ruangans['GDG-01'] ?? $defaultRuanganId,
            ],
            [
                'kode_bmn' => 'BMN-2026-006',
                'nama_barang' => 'Kendaraan Dinas Toyota Avanza',
                'kategori' => 'Kendaraan',
                'lokasi_simpan' => 'Parkiran Kantor',
                'status' => 'terpakai',
                'ref_ruangan_id' => $ruangans['GDG-01'] ?? $defaultRuanganId,
            ],
            [
                'kode_bmn' => 'BMN-2026-007',
                'nama_barang' => 'Sepeda Motor Dinas Honda Vario',
                'kategori' => 'Kendaraan',
                'lokasi_simpan' => 'Parkiran Kantor',
                'status' => 'tersedia',
                'ref_ruangan_id' => $ruangans['GDG-01'] ?? $defaultRuanganId,
            ],
            [
                'kode_bmn' => 'BMN-2026-008',
                'nama_barang' => 'Printer Epson L3210',
                'kategori' => 'Elektronik',
                'lokasi_simpan' => 'Ruang Tata Usaha',
                'status' => 'rusak',
                'ref_ruangan_id' => $ruangans['R-102'] ?? $defaultRuanganId,
            ],
            [
                'kode_bmn' => 'BMN-2026-009',
                'nama_barang' => 'Lemari Arsip Besi',
                'kategori' => 'Arsip',
                'lokasi_simpan' => 'Ruang Kearsipan',
                'status' => 'tersedia',
                'ref_ruangan_id' => $ruangans['GDG-01'] ?? $defaultRuanganId,
            ],
            [
                'kode_bmn' => 'BMN-2026-010',
                'nama_barang' => 'Mic Wireless Shure',
                'kategori' => 'Elektronik',
                'lokasi_simpan' => 'Ruang Rapat Utama',
                'status' => 'tersedia',
                'ref_ruangan_id' => $ruangans['R-101'] ?? $defaultRuanganId,
            ],
            [
                'kode_bmn' => 'BMN-2026-011',
                'nama_barang' => 'AC Split Daikin 1PK',
                'kategori' => 'Elektronik',
                'lokasi_simpan' => 'Ruang Pimpinan',
                'status' => 'tersedia',
                'ref_ruangan_id' => $ruangans['R-201'] ?? $defaultRuanganId,
            ],
            [
                'kode_bmn' => 'BMN-2026-012',
                'nama_barang' => 'Whiteboard Magnetic',
                'kategori' => 'ATK',
                'lokasi_simpan' => 'Ruang Rapat Kecil',
                'status' => 'tersedia',
                'ref_ruangan_id' => $ruangans['R-101'] ?? $defaultRuanganId,
            ],
        ];

        foreach ($items as $item) {
            $item['qr_code'] = url('/scan/' . $item['kode_bmn']);
            Item::updateOrCreate(
                ['kode_bmn' => $item['kode_bmn']],
                $item
            );
        }

        $this->command->info('✅ ' . count($items) . ' item demo berhasil dibuat!');
    }
}
