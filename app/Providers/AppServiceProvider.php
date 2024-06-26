<?php

namespace App\Providers;

use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

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
        Relation::morphMap([
            'customer' => Customer::class,
            'contact' => Contact::class
        ]);
    }
}
