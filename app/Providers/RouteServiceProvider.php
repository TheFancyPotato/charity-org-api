<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        Route::macro('apiResourceWithSoftDeletes', function (string $name, string $controller, array $options = []) {
            if (!in_array('trash', $options['except'] ?? [])) {
                Route::get($name . '/trash', [$controller, 'trash'])->name($name . '.trash');
            }

            Route::apiResource($name, $controller, $options);

            if (!in_array('restore', $options['except'] ?? [])) {
                Route::post($name . '/restore/{' . Str::camel(Str::singular($name)) . '}', [$controller, 'restore'])->name($name . '.restore');
            }

            if (!in_array('forceDelete', $options['except'] ?? [])) {
                Route::delete($name . '/force/{' . Str::camel(Str::singular($name)) . '}', [$controller, 'forceDelete'])->name($name . '.forceDelete');
            }
        });
    }
}
