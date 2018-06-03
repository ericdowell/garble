<?php

namespace Garble\Http\Requests;

class ToDoRequest extends TextRequest
{
    /**
     * The validation rules that apply to the request.
     */
    protected $rules = [
        'title' => 'required',
        'completed' => 'sometimes|required|boolean',
        'body' => 'sometimes|string',
    ];
}
