<?php

use App\Http\Middleware\LogRequests;
use App\Http\Middleware\RedirectIfWrongRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

spl_autoload_register(function ($class): void {
    $prefix = 'Fahiem\\FilamentPinpoint\\';
    $base_dir = __DIR__.'/../vendor/fahiem/filament-pinpoint/src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir.str_replace('\\', '/', $relative_class).'.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(LogRequests::class);
        $middleware->alias([
            'role' => RedirectIfWrongRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->is('admin*') && auth()->check() && ! auth()->user()->isAdmin()) {
                return redirect(auth()->user()->homeUrl())
                    ->with('warning', 'Halaman itu khusus admin, Bang.');
            }
        });

        $exceptions->render(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 403 && $request->is('admin*') && auth()->check() && ! auth()->user()->isAdmin()) {
                return redirect(auth()->user()->homeUrl())
                    ->with('warning', 'Halaman itu khusus admin, Bang.');
            }
        });

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
