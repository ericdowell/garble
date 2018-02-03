<?php

namespace Garble;

use Illuminate\Database\Eloquent\Model;

/**
 * Garble\Role
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Garble\Permission[] $permissions
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string|null $label
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Role whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Role whereUpdatedAt($value)
 */
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
