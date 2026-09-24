<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ItemReport;
use App\Services\ItemService;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function __construct(
        protected ItemService $itemService,
        protected ReportService $reportService
    ) {}

    /**
     * Get aggregate summary of BMN asset condition and statistics.
     */
    public function summary(): JsonResponse
    {
        $stats = $this->reportService->getAssetStatistics();

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }

    /**
     * List all reports with pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $query = ItemReport::with(['item', 'user'])->latest();

        if ($status = $request->input('status_validasi')) {
            $query->where('status_validasi', $status);
        }

        $reports = $query->paginate($request->integer('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $reports->items(),
            'meta' => [
                'current_page' => $reports->currentPage(),
                'last_page' => $reports->lastPage(),
                'per_page' => $reports->perPage(),
                'total' => $reports->total(),
            ],
        ]);
    }

    /**
     * Submit an asset condition report from mobile/scanner.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'kode_bmn' => 'required|string|exists:items,kode_bmn',
            'kondisi_aktual' => 'required|in:tersedia,terpakai,servis,rusak,hilang',
            'foto_bukti' => 'required|image|max:5120',
            'catatan' => 'nullable|string',
        ]);

        $item = $this->itemService->findByKodeBmn($validated['kode_bmn']);
        $path = $request->file('foto_bukti')->store('reports', 'public');

        $report = $this->reportService->submitReport(
            item: $item,
            userId: Auth::id() ?? 1,
            kondisiAktual: $validated['kondisi_aktual'],
            catatan: $validated['catatan'] ?? null,
            fotoBuktiPath: $path
        );

        return response()->json([
            'success' => true,
            'message' => 'Laporan fisik aset berhasil dikirim, menunggu validasi administrator.',
            'data' => $report,
        ], 201);
    }
}
