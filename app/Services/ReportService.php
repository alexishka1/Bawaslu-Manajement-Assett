<?php

namespace App\Services;

use App\Models\Item;
use App\Models\ItemReport;
use App\Models\ItemTransaction;
use Illuminate\Support\Facades\DB;

class ReportService
{
    /**
     * Get aggregate statistics of BMN assets and validation status.
     */
    public function getAssetStatistics(): array
    {
        return [
            'total_items' => Item::count(),
            'tersedia' => Item::where('status', 'tersedia')->count(),
            'terpakai' => Item::where('status', 'terpakai')->count(),
            'servis' => Item::where('status', 'servis')->count(),
            'rusak' => Item::where('status', 'rusak')->count(),
            'laporan_menunggu' => ItemReport::where('status_validasi', 'menunggu')->count(),
            'total_transaksi' => ItemTransaction::count(),
        ];
    }

    /**
     * Record a new physical asset report from staff.
     */
    public function submitReport(
        Item $item,
        int $userId,
        string $kondisiAktual,
        ?string $catatan,
        string $fotoBuktiPath
    ): ItemReport {
        return DB::transaction(function () use ($item, $userId, $kondisiAktual, $catatan, $fotoBuktiPath) {
            return ItemReport::create([
                'item_id' => $item->id,
                'user_id' => $userId,
                'kondisi_aktual' => $kondisiAktual,
                'catatan' => $catatan,
                'foto_bukti' => $fotoBuktiPath,
                'status_validasi' => 'menunggu',
            ]);
        });
    }

    /**
     * Get monthly metrics for transactions and asset reports.
     */
    public function getMonthlyMetrics(int $year): array
    {
        $transactionsByMonth = ItemTransaction::select(
            DB::raw("strftime('%m', created_at) as month"),
            DB::raw('count(*) as count')
        )
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $reportsByMonth = ItemReport::select(
            DB::raw("strftime('%m', created_at) as month"),
            DB::raw('count(*) as count')
        )
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $key = str_pad((string) $m, 2, '0', STR_PAD_LEFT);
            $months[$m] = [
                'month' => $key,
                'transactions' => $transactionsByMonth[$key] ?? 0,
                'reports' => $reportsByMonth[$key] ?? 0,
            ];
        }

        return $months;
    }
}
