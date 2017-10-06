<?php

namespace Garble\Http\Controllers;

use Route;
use Garble\Text;
use Garble\Http\Requests\TextsRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class TextController extends Controller
{
    /**
     * @var string
     */
    protected $template;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $typeName;
    /**
     * @var \Illuminate\Routing\Route
     */
    protected $route;
    /**
     * @var array
     */
    protected $mergeData = [];
    /**
     * Name of the affected Eloquent model.
     *
     * @var string
     */
    protected $model;
    /**
     * @var Model
     */
    protected $modelInstance;
    /**
     * @var array
     */
    protected $actionMap = [
        'create' => 'store',
        'edit' => 'update',
    ];
    protected $publicActions = [
        'index',
        'show',
    ];
    /**
     * @var string
     */
    protected $formAction;

    /**
     * TextController constructor.
     */
    final public function __construct()
    {
        $this->setupModel()
            ->setupDefaults();

        if (! in_array($this->formAction, $this->publicActions)) {
            $this->middleware('auth');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->render(['all' => Text::allByType($this->type)]);
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function storeModel(TextsRequest $request)
    {
        $modelAttributes = [];
        foreach ($this->modelInstance->getFillable() as $key) {
            $modelAttributes[$key] = $request->input($key, false);
        }
        $model = $this->modelInstance->create($modelAttributes);

        $attributes = [
            'slug' => $request->input('slug'),
            'text_type' => $this->type,
            'text_id' => $model->id,
            'user_id' => $request->input('user_id'),
        ];
        /** @var Text $text */
        $text = Text::create($attributes);

        $text->save();

        return $this->redirectToIndex();
    }

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        ${$this->type} = $instance = Text::findBySlug($slug);

        return $this->render(compact($this->type, 'instance'));
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
            'route' => [sprintf('%s.%s', $this->type, $this->formAction), $instance->slug],
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function updateModel(TextsRequest $request, $slug)
    {
        $text = Text::findBySlug($slug);

        if ($slug != $text->slug) {
            $text->update(['slug' => $slug]);
        }
        /** @var Model $model */
        $model = $text->text;
        //Loop over fillable fields
        foreach ($model->getFillable() as $key) {
            $input = $request->input($key);
            if (is_null($input) && $model->hasCast($key, 'boolean')) {
                $input = false;
            }
            $model->{$key} = $input;
        }
        $model->save();

        return $this->redirectToIndex();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $slug
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
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
        return redirect()->route($this->type.'.index');
    }

    /**
     * @return \Illuminate\Routing\Route
     */
    protected function route()
    {
        return $this->route;
    }

    /**
     * @param $data
     *
     * @return \Illuminate\Http\Response
     */
    protected function render($data = [])
    {
        $html = view($this->template, $data, $this->mergeData)->render();

        return response($html);
    }

    /**
     * @param mixed $items
     *
     * @return $this
     */
    protected function pushToDefaults(array $items)
    {
        $this->mergeData = array_merge($this->mergeData, $items);

        return $this;
    }

    /**
     * @throws ModelNotFoundException
     *
     * @return $this
     */
    protected function setupModel()
    {
        /** @var ModelNotFoundException $modelException */
        $modelException = with(new ModelNotFoundException())->setModel($this->model);
        if (! class_exists($modelException->getModel())) {
            throw $modelException;
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function setupDefaults()
    {
        $this->route = Route::current();
        if (method_exists($this->route, 'getName') && ! empty($this->route->getName())) {
            $this->template = $this->route()->getName();

            $this->setTypeAndFormAction()
                ->setTypeName()
                ->setModelInstance();
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function setTypeAndFormAction()
    {
        list($type, $action) = explode('.', $this->template);

        if (array_key_exists($action, $this->actionMap)) {
            $action = $this->actionMap[$action];
        }
        $this->type = $type;
        $this->formAction = $action;
        $btnMessage = sprintf('%s %s', ucfirst($this->formAction), ucfirst($this->type));

        $data = compact('type', 'btnMessage', 'action');

        return $this->pushToDefaults($data);
    }

    /**
     * @return $this
     */
    protected function setTypeName()
    {
        $this->typeName = $typeName = str_plural(ucfirst($this->type));

        return $this->pushToDefaults(compact('typeName'));
    }

    /**
     * @return $this
     */
    protected function setModelInstance()
    {
        $this->modelInstance = $instance = new $this->model();

        return $this->pushToDefaults(compact('instance'));
    }
}
