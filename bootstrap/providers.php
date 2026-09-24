<?php

use App\Providers\AppServiceProvider;
use App\Providers\Filament\AdminPanelProvider;

return [
    AppServiceProvider::class,
    AdminPanelProvider::class,
    \Fahiem\FilamentPinpoint\FilamentPinpointServiceProvider::class,
];
