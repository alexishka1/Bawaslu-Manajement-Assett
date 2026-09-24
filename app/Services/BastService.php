<?php

namespace App\Services;

use App\Exceptions\BastGenerationException;
use App\Models\BastPemakaianHeader;
use App\Models\BastPengembalianHeader;
use App\Models\ItemTransaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BastService
{
    /**
     * Generate PDF for single-item transaction.
     *
     * @throws BastGenerationException
     */
    public function generateSingleBastPdf(ItemTransaction $transaction): array
    {
        try {
            $transaction->load('item');

            $pdf = Pdf::loadView('pdf.bast', compact('transaction'))
                ->setPaper('a4', 'portrait');

            $filename = 'BAST_'.($transaction->item->kode_bmn ?? 'N-A').'_'.$transaction->tanggal_pinjam->format('Ymd').'.pdf';

            return [
                'pdf' => $pdf,
                'filename' => $filename,
            ];
        } catch (\Throwable $e) {
            throw new BastGenerationException('Gagal membuat dokumen BAST: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Generate PDF for multi-item BAST Pemakaian.
     *
     * @throws BastGenerationException
     */
    public function generatePemakaianPdf(BastPemakaianHeader $header): array
    {
        try {
            $header->load(['details.item', 'pihakPertama', 'pihakKedua', 'pembuat']);

            $verifyUrl = route('bast.pemakaian.verify', $header);
            $qrSvg = QrCode::format('svg')->size(95)->margin(0)->generate($verifyUrl);
            $qrCodeBase64 = 'data:image/svg+xml;base64,'.base64_encode($qrSvg);

            $ttdPihak1Base64 = $this->getSignatureBase64($header->ttd_pihak1_url);
            $ttdPihak2Base64 = $this->getSignatureBase64($header->ttd_pihak2_url);

            $pdf = Pdf::loadView('pdf.bast-pemakaian', compact(
                'header',
                'verifyUrl',
                'qrCodeBase64',
                'ttdPihak1Base64',
                'ttdPihak2Base64'
            ))->setPaper('a4', 'portrait');

            $safeNomor = str_replace(['/', '\\', ' '], '_', $header->nomor_bast ?? 'DRAFT_'.$header->id);
            $filename = 'BAST_PEMAKAIAN_'.$safeNomor.'.pdf';

            return [
                'pdf' => $pdf,
                'filename' => $filename,
            ];
        } catch (\Throwable $e) {
            throw new BastGenerationException('Gagal membuat dokumen BAST Pemakaian: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Generate PDF for multi-item BAST Pengembalian.
     *
     * @throws BastGenerationException
     */
    public function generatePengembalianPdf(BastPengembalianHeader $header): array
    {
        try {
            $header->load(['details.item', 'pihakMenyerahkan', 'pihakMenerima', 'pembuat']);

            $verifyUrl = route('bast.pengembalian.verify', $header);
            $qrSvg = QrCode::format('svg')->size(95)->margin(0)->generate($verifyUrl);
            $qrCodeBase64 = 'data:image/svg+xml;base64,'.base64_encode($qrSvg);

            $ttdPihak1Base64 = $this->getSignatureBase64($header->ttd_pihak1_url);
            $ttdPihak2Base64 = $this->getSignatureBase64($header->ttd_pihak2_url);

            $pdf = Pdf::loadView('pdf.bast-pengembalian', compact(
                'header',
                'verifyUrl',
                'qrCodeBase64',
                'ttdPihak1Base64',
                'ttdPihak2Base64'
            ))->setPaper('a4', 'portrait');

            $safeNomor = str_replace(['/', '\\', ' '], '_', $header->nomor_bast_pengembalian ?? 'DRAFT_'.$header->id);
            $filename = 'BAST_PENGEMBALIAN_'.$safeNomor.'.pdf';

            return [
                'pdf' => $pdf,
                'filename' => $filename,
            ];
        } catch (\Throwable $e) {
            throw new BastGenerationException('Gagal membuat dokumen BAST Pengembalian: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Helper to safely retrieve signature image as base64 string for DomPDF.
     */
    protected function getSignatureBase64(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        if (str_starts_with($url, 'data:image/')) {
            return $url;
        }

        $cleanPath = ltrim(str_replace('/storage/', '', $url), '/');

        if (Storage::disk('public')->exists($cleanPath)) {
            $content = Storage::disk('public')->get($cleanPath);

            return 'data:image/png;base64,'.base64_encode($content);
        }

        $fullPublicPath = public_path(ltrim($url, '/'));
        if (file_exists($fullPublicPath)) {
            $content = file_get_contents($fullPublicPath);

            return 'data:image/png;base64,'.base64_encode($content);
        }

        return null;
    }
}
