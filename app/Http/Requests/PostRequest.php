<?php

namespace Garble\Http\Requests;

class PostRequest extends TextRequest
{
    /**
     * The validation rules that apply to the request.
     */
    protected $rules = [
        'title' => 'required',
        'body' => 'required',
    ];
}
