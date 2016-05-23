<?php

namespace Garble\Http\Requests;

class PostsRequest extends TextsRequest
{
    /**
     * The validation rules that apply to the request.
     */
    protected $rules = [
        'title' => 'required',
        'body' => 'required',
    ];
}
