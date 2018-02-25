<?php

namespace Garble;

use Illuminate\Database\Eloquent\Model;

/**
 * Garble\ToDo.
 *
 * @property-read \Garble\User $user
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @property bool $completed
 * @property string|null $body
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\ToDo whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\ToDo whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\ToDo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\ToDo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\ToDo whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\ToDo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\ToDo whereUserId($value)
 */
class ToDo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'completed',
        'body',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'completed' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
