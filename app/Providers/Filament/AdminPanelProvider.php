<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use App\Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\AssetStatusChart;
use App\Filament\Widgets\KategoriDistributionChart;
use App\Filament\Widgets\PeminjamLocationMapWidget;
use App\Filament\Widgets\TopBorrowedItemsChart;
use App\Filament\Widgets\MonthlyTransactionTrendChart;
use App\Filament\Widgets\RecentTransactionsWidget;
use App\Filament\Widgets\OverdueLoansWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('Bawaslu Management Asset')
            ->colors([
                'primary' => Color::hex('#B91C1C'),   // Merah Bawaslu (semangat kebangsaan)
                'danger'  => Color::hex('#DC2626'),
                'warning' => Color::hex('#D97706'),   // Emas/gold (keagungan, sinkron dgn logo)
                'success' => Color::hex('#15803D'),
                'info'    => Color::hex('#1D4ED8'),
                'gray'    => Color::Slate,
            ])
            ->brandLogo(asset('images/logo.jpg'))
            ->brandLogoHeight('3rem')
            ->favicon(asset('images/logo.jpg'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                StatsOverview::class,
                PeminjamLocationMapWidget::class,
                AssetStatusChart::class,
                KategoriDistributionChart::class,
                TopBorrowedItemsChart::class,
                MonthlyTransactionTrendChart::class,
                RecentTransactionsWidget::class,
                OverdueLoansWidget::class,
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => <<<'HTML'
                    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                    <script>
                        function peminjamMapWidget(locations) {
                            return {
                                map: null,
                                locations: locations || [],

                                init() {
                                    this.ensureLeaflet(() => this.renderMap());
                                },

                                ensureLeaflet(cb) {
                                    if (typeof L !== 'undefined' && typeof L.map === 'function') {
                                        cb();
                                        return;
                                    }
                                    const interval = setInterval(() => {
                                        if (typeof L !== 'undefined' && typeof L.map === 'function') {
                                            clearInterval(interval);
                                            cb();
                                        }
                                    }, 100);
                                    setTimeout(() => clearInterval(interval), 5000);
                                },

                                renderMap() {
                                    const container = this.$refs.mapContainer;
                                    if (!container || container._leaflet_id) return;

                                    const center = this.locations.length > 0
                                        ? [this.locations[0].lat, this.locations[0].lng]
                                        : [-5.3971, 105.2668];

                                    const zoom = this.locations.length > 0 ? 13 : 11;

                                    this.map = L.map(container, { scrollWheelZoom: true }).setView(center, zoom);

                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                                        maxZoom: 19
                                    }).addTo(this.map);

                                    const markers = [];
                                    this.locations.forEach(loc => {
                                        const isDipinjam = loc.status === 'dipinjam';
                                        const color = isDipinjam ? '#ef4444' : '#22c55e';
                                        const badgeText = isDipinjam ? 'Masih Dipinjam' : 'Sudah Dikembalikan';
                                        const badgeBg = isDipinjam ? '#fee2e2' : '#dcfce7';
                                        const badgeColor = isDipinjam ? '#991b1b' : '#166534';

                                        const customHtml = '<div style="background:' + color + ';width:22px;height:22px;border-radius:50%;border:3px solid #ffffff;box-shadow:0 2px 8px rgba(0,0,0,0.4);display:flex;align-items:center;justify-content:center;"><div style="background:white;width:6px;height:6px;border-radius:50%;"></div></div>';

                                        const icon = L.divIcon({
                                            className: 'custom-pin',
                                            html: customHtml,
                                            iconSize: [22, 22],
                                            iconAnchor: [11, 11],
                                            popupAnchor: [0, -12]
                                        });

                                        const marker = L.marker([loc.lat, loc.lng], { icon: icon }).addTo(this.map);

                                        marker.bindPopup(
                                            '<div style="font-family: inherit; font-size: 13px; line-height: 1.5; min-width: 220px; padding: 2px; color: #1f2937;">' +
                                            '<div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-bottom: 6px;">' +
                                            '<strong style="font-size: 14px; color: #111827;">' + loc.popup.nama + '</strong>' +
                                            '<span style="background:' + badgeBg + '; color:' + badgeColor + '; font-size: 10px; font-weight: bold; padding: 2px 6px; border-radius: 9999px;">' + badgeText + '</span>' +
                                            '</div>' +
                                            '<div style="margin-bottom: 4px;">📦 <strong>Barang:</strong> ' + loc.popup.barang + '</div>' +
                                            '<div style="margin-bottom: 4px;">📍 <strong>Alamat:</strong> ' + loc.popup.alamat + '</div>' +
                                            '<div style="margin-bottom: 8px; color: #6b7280; font-size: 12px;">📄 ' + loc.popup.nomor_bast + ' (' + loc.popup.tanggal + ')</div>' +
                                            '<div><a href="' + loc.popup.view_url + '" style="display: inline-block; background: #2563eb; color: #ffffff; padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; text-decoration: none;">Lihat Dokumen BAST &rarr;</a></div>' +
                                            '</div>'
                                        );

                                        markers.push(marker);
                                    });

                                    if (markers.length > 1) {
                                        const group = L.featureGroup(markers);
                                        this.map.fitBounds(group.getBounds().pad(0.25));
                                    } else if (markers.length === 1) {
                                        this.map.setView([this.locations[0].lat, this.locations[0].lng], 14);
                                    }

                                    setTimeout(() => this.map && this.map.invalidateSize(), 200);
                                    setTimeout(() => this.map && this.map.invalidateSize(), 600);
                                }
                            };
                        }
                        window.peminjamMapWidget = peminjamMapWidget;
                        document.addEventListener('alpine:init', function() {
                            if (window.Alpine) {
                                window.Alpine.data('peminjamMapWidget', peminjamMapWidget);
                            }
                        });
                    </script>
                HTML
            )
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
