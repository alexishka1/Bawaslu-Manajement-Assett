<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemReportRequest;
use App\Services\ItemService;
use App\Services\ReportService;
use Illuminate\Support\Facades\Auth;

class ScanController extends Controller
{
    public function __construct(
        protected ItemService $itemService,
        protected ReportService $reportService
    ) {}

    public function index()
    {
        return view('scanner');
    }

    public function show($kode_bmn)
    {
        $item = $this->itemService->findByKodeBmn($kode_bmn);

        return view('scan', compact('item'));
    }

    public function store(StoreItemReportRequest $request, $kode_bmn)
    {
        $item = $this->itemService->findByKodeBmn($kode_bmn);

        $path = $request->file('foto_bukti')->store('reports', 'public');

        $this->reportService->submitReport(
            item: $item,
            userId: Auth::id(),
            kondisiAktual: $request->validated('kondisi_aktual'),
            catatan: $request->validated('catatan'),
            fotoBuktiPath: $path
        );

        return redirect()->route('scan.show', $kode_bmn)->with('success', 'Laporan berhasil dikirim! Menunggu validasi admin.');
    }
}
