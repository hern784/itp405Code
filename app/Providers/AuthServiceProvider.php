<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Invoice;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view-invoice', function (User $user, Invoice $invoice) {
            return $user->email === $invoice->customer->email;
        });

        // global auth 
        Gate::before(function (User $user) {
            if ($user->isAdmin()) {
                return true;
            }
        });
    }
}
