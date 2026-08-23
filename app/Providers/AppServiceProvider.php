<?php

namespace App\Providers;

use App\Repositories\Contracts\CourseRepositoryInterface;
use App\Repositories\Eloquent\CourseRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            CourseRepositoryInterface::class,
            CourseRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

