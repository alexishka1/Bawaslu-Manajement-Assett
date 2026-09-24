<?php

namespace Tests\Feature;

use App\Filament\Pages\Dashboard;
use App\Filament\Widgets\AssetStatusChart;
use App\Filament\Widgets\KategoriDistributionChart;
use App\Filament\Widgets\MonthlyTransactionTrendChart;
use App\Filament\Widgets\OverdueLoansWidget;
use App\Filament\Widgets\RecentTransactionsWidget;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\TopBorrowedItemsChart;
use App\Models\Item;
use App\Models\ItemTransaction;
use App\Models\User;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardAndBrandingTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
    }

    public function test_custom_dashboard_columns(): void
    {
        $dashboard = new Dashboard();
        $this->assertEquals([
            'md' => 2,
            'xl' => 3,
        ], $dashboard->getColumns());
    }

    public function test_overdue_loans_widget_hidden_when_no_overdue_loans(): void
    {
        $this->assertFalse(OverdueLoansWidget::canView());
    }

    public function test_overdue_loans_widget_visible_when_overdue_loans_exist(): void
    {
        $item = Item::factory()->create();

        ItemTransaction::create([
            'item_id' => $item->id,
            'nama_peminjam' => 'Pegawai Terlambat',
            'divisi' => 'Subbag Umum',
            'tanggal_pinjam' => now()->subDays(10),
            'tanggal_kembali' => null,
            'status' => 'dipinjam',
        ]);

        $this->assertTrue(OverdueLoansWidget::canView());
    }

    public function test_all_custom_charts_and_widgets_render_successfully(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(AssetStatusChart::class)->assertOk();
        Livewire::test(KategoriDistributionChart::class)->assertOk();
        Livewire::test(TopBorrowedItemsChart::class)->assertOk();
        Livewire::test(MonthlyTransactionTrendChart::class)->assertOk();
        Livewire::test(RecentTransactionsWidget::class)->assertOk();
        Livewire::test(StatsOverview::class)->assertOk();
    }
}
