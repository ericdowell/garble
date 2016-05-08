<?php

namespace Garble;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'slug';
    /**
     * @var bool
     */
    public $incrementing = false;

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
     * @param $type
     *
     * @return Collection
     */
    public static function allByType($type)
    {
        return self::where('text_type', $type)->get();
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
}
