<?php

namespace Garble;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Garble\Text.
 *
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $text
 * @property-read \Garble\User $user
 * @mixin \Eloquent
 * @property int $id
 * @property string $slug
 * @property string $text_type
 * @property int $text_id
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Text whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Text whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Text whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Text whereTextId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Text whereTextType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Text whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Garble\Text whereUserId($value)
 */
class Text extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text_type',
        'text_id',
        'user_id',
        'slug',
    ];
    /**
     * @var bool
     */
    public $incrementing = false;
    /**
     * @var string
     */
    protected $primaryKey = 'slug';

    /**
     * @var array
     */
    protected static $rules = [
        'slug' => 'required|unique:texts,slug',
        'user_id' => 'required',
        'text_type' => 'required',
    ];

    /**
     * @param $slug
     *
     * @return mixed
     */
    public static function findBySlug($slug)
    {
        return self::with('user')->findOrFail($slug);
    }

    /**
     * @return mixed
     */
    public static function findByCurrentSlug()
    {
        self::create()
        $slug = request()->input('slug');

        return self::findBySlug($slug);
    }

    /**
     * @param $type
     *
     * @return Collection
     */
    public static function allByType($type)
    {
        return self::where('text_type', str_singular($type))->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function text()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return array
     */
    public static function rules()
    {
        return self::$rules;
    }
}
