<?php

namespace Garble;

use Illuminate\Database\Eloquent\Model;

/**
 * Garble\Note
 *
 * @property-read \Garble\User $user
 * @mixin \Eloquent
 * @property int $id
 * @property string $body
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Note whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Note whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Note whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Note whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Note whereUserId($value)
 */
class Note extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body',
        'user_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
