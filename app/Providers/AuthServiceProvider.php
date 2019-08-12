<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * @param GateContract $gate
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('isAdmin', function($user) {
            return $user->role == 'superuser';
        });

        $gate->define('isRegionalUser', function($user) {
            return $user->role == 'regionaluser';
        });

        $gate->define('isManager', function($user) {
            return $user->role == 'manager';
        });

        $gate->define('isUser', function($user) {
            return $user->role == 'user';
        });

    }
}
