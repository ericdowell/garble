<?php

namespace Garble;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

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
