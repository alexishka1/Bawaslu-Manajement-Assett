<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\RefRuangan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@bawaslu.go.id'],
            [
                'name' => 'Administrator Bawaslu',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'staff@bawaslu.go.id'],
            [
                'name' => 'Staf Lapangan',
                'password' => bcrypt('password'),
                'role' => 'staff',
                'email_verified_at' => now(),
            ]
        );

        $ruangans = [
            [
                'kode_ruangan' => 'R-101',
                'nama_ruangan' => 'Ruang Sidang Pleno / Penanganan Sengketa',
                'lantai' => 'Lantai 1',
                'gedung' => 'Gedung Utama',
                'penanggung_jawab' => 'Dr. H. Rakhmat Bagja, S.H., LL.M.',
                'nip_penanggung_jawab' => '198002102005011002',
                'keterangan' => 'Ruang sidang penanganan pelanggaran & sengketa proses pemilu',
            ],
            [
                'kode_ruangan' => 'R-102',
                'nama_ruangan' => 'Ruang Pelayanan Terpadu Satu Pintu (PTSP)',
                'lantai' => 'Lantai 1',
                'gedung' => 'Gedung Utama',
                'penanggung_jawab' => 'Budi Santoso, S.AP.',
                'nip_penanggung_jawab' => '198506152009121003',
                'keterangan' => 'Loket penerimaan laporan dan informasi publik',
            ],
            [
                'kode_ruangan' => 'GDG-01',
                'nama_ruangan' => 'Gudang Penyimpanan BMN & Logistik',
                'lantai' => 'Lantai 1',
                'gedung' => 'Gedung Sayap Barat',
                'penanggung_jawab' => 'Ahmad Fauzi, A.Md.',
                'nip_penanggung_jawab' => '199003202014021001',
                'keterangan' => 'Tempat penyimpanan aset cadangan dan inventaris baru',
            ],
            [
                'kode_ruangan' => 'R-201',
                'nama_ruangan' => 'Ruang Kerja Pimpinan / Ketua Bawaslu',
                'lantai' => 'Lantai 2',
                'gedung' => 'Gedung Utama',
                'penanggung_jawab' => 'Ketua Bawaslu RI',
                'nip_penanggung_jawab' => '197501012000031001',
                'keterangan' => 'Ruang kerja Ketua Bawaslu',
            ],
            [
                'kode_ruangan' => 'R-202',
                'nama_ruangan' => 'Ruang Kerja Anggota Komisioner',
                'lantai' => 'Lantai 2',
                'gedung' => 'Gedung Utama',
                'penanggung_jawab' => 'Lolly Suhenty, S.Sos., M.H.',
                'nip_penanggung_jawab' => '197802282003122002',
                'keterangan' => 'Ruang kerja komisioner divisi pencegahan dan parmas',
            ],
            [
                'kode_ruangan' => 'R-203',
                'nama_ruangan' => 'Ruang Sekretariat & Subbagian Umum',
                'lantai' => 'Lantai 2',
                'gedung' => 'Gedung Utama',
                'penanggung_jawab' => 'Sekretaris Jenderal Bawaslu',
                'nip_penanggung_jawab' => '197304121998031002',
                'keterangan' => 'Pusat administrasi, kepegawaian, dan pengelolaan BMN',
            ],
            [
                'kode_ruangan' => 'R-204',
                'nama_ruangan' => 'Ruang Server & Data Center IT',
                'lantai' => 'Lantai 2',
                'gedung' => 'Gedung Utama',
                'penanggung_jawab' => 'Ir. Eko Prasetyo, M.Kom.',
                'nip_penanggung_jawab' => '198711052010121004',
                'keterangan' => 'Ruang pendingin khusus server database Siwaslu dan JDIH',
            ],
        ];

        foreach ($ruangans as $rData) {
            RefRuangan::firstOrCreate(
                ['kode_ruangan' => $rData['kode_ruangan']],
                $rData
            );
        }

        // Hubungkan item yang belum ada ruangannya ke Ruang Sidang atau Gudang
        $defaultRuangan = RefRuangan::where('kode_ruangan', 'R-101')->first();
        if ($defaultRuangan) {
            Item::whereNull('ref_ruangan_id')->update([
                'ref_ruangan_id' => $defaultRuangan->id,
            ]);
        }

        $this->call([
            DemoItemSeeder::class,
        ]);
    }
}
