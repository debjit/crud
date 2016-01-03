<?php
namespace BlackfyreStudio\CRUD;

use BlackfyreStudio\CRUD\Models\Permission;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);

        $gate->before(function ($user, $ability) {
            return \Auth::user()->isRoot();
        });

        foreach ($this->getPermissions() as $permission) {

            /** @var Permission $permission */

            $gate->define($permission->name, function () use ($permission) {
                return \Auth::user()->hasPermission($permission);
            });
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    protected function getPermissions()
    {
        return Permission::with('roles.permissions')->get();
    }
}