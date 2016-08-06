<?php

use Garble\Role;
use Garble\Permission;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $existingRole = Role::whereName('admin')->get()->first();
        if ((bool) $existingRole) {
            $roleInfo = [
                'name' => 'admin',
                'label' => 'Admin User',
            ];
            factory(Role::class)->create($roleInfo)->save();
        }

        /** @var Role $admin */
        $admin = Role::whereName('admin')->get()->first();
        foreach (Route::getRoutes()->getRoutes() as $route) {
            /* @var \Illuminate\Routing\Route $route */
            $action = $route->getAction();

            $homeOrAuth = (stristr($action['controller'], 'auth') && stristr($action['controller'], 'home'));

            if (array_key_exists('controller', $action) && ! $homeOrAuth) {
                // You can also use explode('@', $action['controller']); here
                // to separate the class name from the method
                $existingPermission = Permission::whereName($action['controller'])->get()->first();
                if ((bool) $existingPermission) {
                    $routeAction = explode('@', $action['controller']);
                    $model = str_replace([$action['namespace'], 'Controller'], ['', ''], $action['controller']);
                    $label = ucfirst($routeAction).ucwords(str_replace('_', ' ', snake_case($model)));
                    $permissionInfo = [
                        'name' => $action['controller'],
                        'label' => $label,
                    ];

                    $permission = factory(Permission::class)->create($permissionInfo)->save();
                    $admin->givePermissionTo($permission);
                }
            }
        }
    }

    /**
     * @return array
     */
    protected function getRouteResources()
    {
        $resources = [];
        foreach (Route::getRoutes()->getRoutes() as $route) {
            /* @var \Illuminate\Routing\Route $route */
            $action = $route->getAction();

            if (array_key_exists('controller', $action) && stristr($action['controller'], 'auth') &&
                stristr($action['controller'], 'home')
            ) {
                // You can also use explode('@', $action['controller']); here
                // to separate the class name from the method
                $existingPermission = Permission::whereName($action['controller'])->get()->first();
                if ((bool) $existingPermission) {
                    list($controller, $routeAction) = explode('@', $action['controller']);

                    $model = str_replace([$action['namespace'], 'Controller'], ['', ''], $controller);
                    $titleCase = ucwords(str_replace('_', ' ', snake_case($model)));
                    $label = ucfirst($routeAction).$titleCase;

                    if (! array_key_exists($controller, $resources)) {
                        $resources[$controller]['parent'] = [
                            'name' => $controller,
                            'label' => 'Access '.$titleCase,
                        ];
                    }

                    $resources[$controller]['children'][] = [
                        'name' => $action['controller'],
                        'label' => $label,
                    ];
                }
            }
        }

        return $resources;
    }
}
