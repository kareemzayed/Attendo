<?php

namespace App\Providers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the 'paginateOrAll' macro for query builder
        Builder::macro('paginateOrAll', function () {
            $query = $this->orderBy(
                request()->input('sort_field', 'id'),
                request()->input('sort_direction', 'asc')
            );

            if (request()->has('all') && request()->input('all') === 'true') {
                return $query->get();
            }

            return $query->paginate(15);
        });
    }
}
