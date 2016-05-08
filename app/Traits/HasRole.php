<?php
/**
 * Created by PhpStorm.
 * User: eric
 * Date: 5/7/16
 * Time: 7:03 PM
 */

namespace Garble\Traits;

use Garble\Role;
use Illuminate\Database\Eloquent\Collection;

trait HasRole
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @param $role
     */
    public function assignRole( $role )
    {
        if( is_string($role)) {
            $this->roles()->sync(
                Role::whereName($role)->firstOrFail()
            );
        }
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * @param string|Collection $role
     *
     * @return bool
     */
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return !! $role->intersect($this->roles)->count();
    }
}
