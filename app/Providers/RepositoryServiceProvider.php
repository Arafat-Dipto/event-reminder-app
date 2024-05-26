<?php

namespace App\Providers;

use App\Repositories\Event\EventRepository;
use App\Repositories\Event\IEventRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(abstract :IEventRepository::class, concrete: EventRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
