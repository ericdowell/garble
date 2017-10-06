<?php

namespace Garble\Http\Requests;

class ToDosRequest extends TextsRequest
{
    /**
     * The validation rules that apply to the request.
     */
    protected $rules = [
        'title' => 'required',
        'completed' => 'sometimes|required|boolean',
    ];
}
