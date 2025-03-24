<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Cart;
use App\Policies\CartPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Cart::class => CartPolicy::class, // Tambahkan policy untuk model Cart
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies(); // Daftarkan semua kebijakan (policies)

        // Admin memiliki akses penuh
        Gate::before(function ($user) {
            if ($user->hasRole('Admin')) {
                return true; // Berikan akses penuh
            }
        });

        // Definisikan akses untuk User biasa
        Gate::define('add-to-cart', function ($user) {
            return $user->hasRole('User');
        });

        Gate::define('update-cart', function ($user) {
            return $user->hasRole('User');
        });

        Gate::define('delete-cart', function ($user) {
            return $user->hasRole('User');
        });
    }
}
