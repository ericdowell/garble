<?php

namespace Garble;

use Illuminate\Database\Eloquent\Model;

/**
 * Garble\Post.
 *
 * @property-read \Garble\User $user
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @property string $body
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Post whereUserId($value)
 */
class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
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
