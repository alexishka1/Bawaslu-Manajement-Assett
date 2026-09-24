<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('report:check-stats', function () {
    $stats = [
        'items_total' => \App\Models\Item::count(),
        'items_tersedia' => \App\Models\Item::where('status', 'tersedia')->count(),
        'items_dipakai' => \App\Models\Item::where('status', 'dipakai')->count(),
        'items_rusak' => \App\Models\Item::where('status', 'rusak')->count(),
        'bast_pemakaian' => \App\Models\BastPemakaianHeader::count(),
        'bast_pengembalian' => \App\Models\BastPengembalianHeader::count(),
        'ruangan' => \App\Models\RefRuangan::count(),
        'pejabat' => \App\Models\RefPejabat::count(),
        'pegawai' => \App\Models\RefPegawai::count(),
        'users' => \App\Models\User::count(),
        'unverified_users' => \App\Models\User::where('is_verified', false)->count(),
    ];
    $this->info(json_encode($stats, JSON_PRETTY_PRINT));
});

Artisan::command('report:generate-pdf', function () {
    $this->info("Mengambil data statistik...");
    $stats = [
        'items_total' => \App\Models\Item::count(),
        'items_tersedia' => \App\Models\Item::where('status', 'tersedia')->count(),
        'items_dipakai' => \App\Models\Item::where('status', 'dipakai')->count(),
        'items_rusak' => \App\Models\Item::where('status', 'rusak')->count(),
        'bast_pemakaian' => \App\Models\BastPemakaianHeader::count(),
        'bast_pengembalian' => \App\Models\BastPengembalianHeader::count(),
        'ruangan' => \App\Models\RefRuangan::count(),
        'pejabat' => \App\Models\RefPejabat::count(),
        'pegawai' => \App\Models\RefPegawai::count(),
        'users' => \App\Models\User::count(),
        'unverified_users' => \App\Models\User::where('is_verified', false)->count(),
    ];

    $logoPath = public_path('images/logo.jpg');
    $logoBase64 = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : null;

    $this->info("Merender PDF laporan dengan DomPDF...");
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.laporan-sistem', compact('stats', 'logoBase64'))
        ->setPaper('a4', 'portrait')
        ->setOption(['isRemoteEnabled' => true, 'isPhpEnabled' => true]);

    $outputPathWorkspace = base_path('LAPORAN_SISTEM_BAWASLU_ASSET.pdf');
    $outputPathArtifact = 'C:\\Users\\ASUS\\.gemini\\antigravity-ide\\brain\\727ecfb3-005c-4fda-9356-99bda8730022\\LAPORAN_SISTEM_BAWASLU_ASSET.pdf';

    $pdfContent = $pdf->output();

    file_put_contents($outputPathWorkspace, $pdfContent);
    $this->info("Berhasil disimpan di Workspace: " . $outputPathWorkspace);

    if (file_exists(dirname($outputPathArtifact))) {
        file_put_contents($outputPathArtifact, $pdfContent);
        $this->info("Berhasil disimpan di Artifact: " . $outputPathArtifact);
    }
});


