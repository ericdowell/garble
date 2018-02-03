<?php

namespace Garble;

use Illuminate\Database\Eloquent\Model;

/**
 * Garble\Permission
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Garble\Role[] $roles
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string|null $label
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Permission whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Permission whereUpdatedAt($value)
 */
class Permission extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
