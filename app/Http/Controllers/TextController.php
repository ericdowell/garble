<?php

namespace Garble\Http\Controllers;

use Garble\Text;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

abstract class TextController extends ModelMorphController
{
    /**
     * @var string
     */
    protected $morphModel = Text::class;

    /**
     * @param FormRequest $request
     * @return array
     */
    protected function beforeStoreModel(FormRequest $request): array
    {
        return [
            'slug' => $request->input('slug'),
            'user_id' => $request->input('user_id'),
        ];
    }

    /**
     * @param FormRequest $request
     * @param Model $instance
     */
    protected function beforeModelUpdate(FormRequest $request, Model &$instance): void
    {
        $slugInput = $request->input('slug');
        if ($slugInput != $instance->slug) {
            $instance->update(['slug' => $slugInput]);
        }
    }
}
