<?php

namespace App\Providers;

use App\Console\Commands\CleanActivityLogCommand;
use App\Services\ActivityLogService;
use App\Services\LogBatch;
use Illuminate\Support\ServiceProvider;

class ActivityLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerCommand();

        $this->app->bind(ActivityLogService::class);

        $this->app->scoped(LogBatch::class);
    }

    public function registerCommand(): void
    {
        $this->commands([
            CleanActivityLogCommand::class,
        ]);
    }
}
