<?php

namespace Garble;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * @param Permission $permission
     *
     * @return array
     */
    public function givePermissionTo(Permission $permission)
    {
        return $this->permissions()->sync($permission);
    }
}
