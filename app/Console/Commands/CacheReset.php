<?php

namespace App\Console\Commands;

use App\Services\PermissionService;
use Illuminate\Console\Command;

class CacheReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:cache-reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the permission cache';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (app(PermissionService::class)->forgetCachedPermissions()) {
            $this->info('Permission cache flushed.');
        } else {
            $this->error('Unable to flush cache.');
        }
    }
}
