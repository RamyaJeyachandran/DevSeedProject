<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('isAdmin',function($users){
            return $users->user_type_id == 1;
        });
        Gate::define('isHospital',function($users){
            return $users->user_type_id == 2;
        });
        Gate::define('isBranch',function($users){
            return $users->user_type_id == 4;
        });
        Gate::define('isDoctor',function($users){
            return $users->user_type_id == 5;
        });
        Gate::define('isAdminHospital',function($users){
            return ($users->user_type_id == 1 || $users->user_type_id == 2);
        });
    }
}
