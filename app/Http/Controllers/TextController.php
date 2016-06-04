<?php

namespace Garble\Http\Controllers;

use Garble\Text;
use Garble\Http\Requests\TextsRequest;
use Illuminate\Database\Eloquent\Model;

abstract class TextController extends TextPublicController
{
    /**
     * TextController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        if (! in_array($this->formAction, $this->publicActions)) {
            $this->middleware('auth');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $options = ['route' => sprintf('%s.%s', $this->type, $this->formAction)];

        return $this->render(compact('options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Garble\Http\Requests\TextsRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function storeModel(TextsRequest $request)
    {
        $modelAttributes = [];
        foreach ($this->modelInstance->getFillable() as $key) {
            $input = $request->input($key);
            if (!empty($input)) {
                $modelAttributes[$key] = $input;
            }
        }
        $model = $this->modelInstance->create($modelAttributes);

        $model->save();

        $attributes = [
            'slug'      => $request->input('slug'),
            'text_type' => $this->type,
            'text_id'   => $model->id,
            'user_id'   => $request->input('user_id'),
        ];
        $text = Text::create($attributes);

        $text->save();

        return $this->redirectToIndex();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $instance = Text::findBySlug($slug);
        $options = [
            'route'  => [sprintf('%s.%s', $this->type, $this->formAction), $instance->slug],
            'method' => 'put',
        ];

        return $this->render(compact('instance', 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Garble\Http\Requests\TextsRequest $request
     * @param  string                             $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function updateModel(TextsRequest $request, $slug)
    {
        $text = Text::findBySlug($slug);
        $attributes = [];

        if ($slug != $text->slug) {
            $text->update(['slug' => $slug]);
        }

        /** @var Model $model */
        $model = $text->text;
        //Loop over fillable fields
        foreach ($model->getFillable() as $key) {
            $input = $request->input($key);
            if (!empty($input)) {
                $attributes[$key] = $input;
            }
        }

        $model->update($attributes);

        return $this->redirectToIndex();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $text = Text::findBySlug($slug);
        /** @var Model $model */
        $model = $text->text;

        $model->destroy($model->id);
        $text->destroy($text->slug);

        return $this->redirectToIndex();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectToIndex()
    {
        return redirect()->route($this->type . '.index');
    }
}
