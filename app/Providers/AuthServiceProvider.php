<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Tax' => 'App\Policies\TaxPolicy',
        'App\User' => 'App\Policies\UserPolicy',
        'App\Product' => 'App\Policies\ProductPolicy',
        'App\Provider' => 'App\Policies\ProviderPolicy',
        'App\Payment' => 'App\Policies\PaymentPolicy',
        'App\Customer' => 'App\Policies\CustomerPolicy',
        'App\Caja' => 'App\Policies\CajaPolicy',
        'App\Purchase' => 'App\Policies\PurchasePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user) {
            if ($user->hasRole('admin')) {
                return true;
            }
        });
    }
}
