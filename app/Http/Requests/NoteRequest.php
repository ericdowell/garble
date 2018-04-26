<?php

namespace Garble\Http\Requests;

class NoteRequest extends TextRequest
{
    /**
     * The validation rules that apply to the request.
     */
    protected $rules = [
        'body' => 'required',
    ];
}
