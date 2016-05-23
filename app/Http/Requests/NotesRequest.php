<?php

namespace Garble\Http\Requests;

class NotesRequest extends TextsRequest
{
    /**
     * The validation rules that apply to the request.
     */
    protected $rules = [
        'body' => 'required',
    ];
}
