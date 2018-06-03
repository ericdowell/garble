<?php

namespace Garble\Http\Controllers;

use Garble\Text;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use EricDowell\ResourceController\Http\Controllers\ModelMorphController;

abstract class TextController extends ModelMorphController
{
    /**
     * @var string
     */
    protected $morphModelClass = Text::class;

    /**
     * Flag for setting/updating 'user_id' as attribute of Eloquent Model.
     *
     * @var bool
     */
    protected $withUser = true;

    /**
     * @param Request $request
     * @return array
     */
    protected function beforeStoreMorphModel(Request $request): array
    {
        return $this->beforeStoreModel($request);
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function beforeStoreModel(Request $request): array
    {
        return [
            'slug' => $request->input('slug'),
        ];
    }

    /**
     * @param Request $request
     * @param Model $instance
     */
    protected function beforeModelUpdate(Request $request, Model &$instance): void
    {
        $slugInput = $request->input('slug');
        if ($slugInput != $instance->slug) {
            $instance->update(['slug' => $slugInput]);
        }
    }
}
