<?php

namespace Garble;

use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}