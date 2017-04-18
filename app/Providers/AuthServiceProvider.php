<?php

namespace Garble\Providers;

use Garble\User;
use Garble\Permission;
use Garble\Policies\IsAdminUser;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => IsAdminUser::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        foreach ($this->getPermissions() as $permission) {
//            \Gate::define($permission->name, function ($user) use ($permission) {
//                /** @var User $user */
//                if ($user->hasRole($permission->roles)) {
//                    return true;
//                }
//            });
//        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    protected function getPermissions()
    {
//        return Permission::with('roles')->get();
    }
}
