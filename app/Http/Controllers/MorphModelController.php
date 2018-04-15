<?php

namespace Garble\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class MorphModelController extends Controller
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
     * @var Model|Builder
     */
    protected $modelInstance;

    /**
     * @var string
     */
    protected $morphModel;

    /**
     * @var array
     */
    protected $actionMap = [
        'create' => 'store',
        'edit' => 'update',
    ];

    /**
     * @var array
     */
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
        $this->setupModel()->setupDefaults();

        if (! in_array($this->formAction, $this->publicActions)) {
            $this->middleware('auth');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function index()
    {
        return $this->render(['all' => $this->allMorphModels()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function create()
    {
        $options = ['route' => sprintf('%s.%s', $this->type, $this->formAction)];

        return $this->render(compact('options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Foundation\Http\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function storeModel(FormRequest $request)
    {
        $model = $this->modelInstance->create($this->getModelAttributes($request));

        $morphType = $this->getMorphType();

        $instance = forward_static_call([$this->morphModel, 'create'], [
            'slug' => $request->input('slug'),
            "{$morphType}_type" => $this->type,
            "{$morphType}_id" => $model->id,
            'user_id' => $request->input('user_id'),
        ]);

        $instance->save();

        return $this->redirectToIndex();
    }

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function show($slug)
    {
        ${$this->type} = $instance = $this->findMorphModel($slug);

        return $this->render(compact($this->type, 'instance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $slug
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function edit($slug)
    {
        $instance = $this->findMorphModel($slug);
        $options = [
            'route' => [sprintf('%s.%s', $this->type, $this->formAction), $instance->slug],
            'method' => 'put',
        ];

        return $this->render(compact('instance', 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Foundation\Http\FormRequest $request
     * @param  string $slug
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function updateModel(FormRequest $request, $slug)
    {
        $instance = $this->findMorphModel($slug);

        $slugInput = $request->input('slug');
        if ($slugInput != $instance->slug) {
            $instance->update(['slug' => $slugInput]);
        }
        $instance->{$this->getMorphType()}->update($this->getModelAttributes($request));

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
        $instance = $this->findMorphModel($slug);
        /** @var Model $model */
        $model = $instance->{$this->getMorphType()};

        $model->destroy($model->id);
        $instance->destroy($instance->slug);

        return $this->redirectToIndex();
    }

    /**
     * @param \Illuminate\Foundation\Http\FormRequest $request
     *
     * @return array
     */
    protected function getModelAttributes(FormRequest $request)
    {
        $modelAttributes = [];

        foreach ($this->modelInstance->getFillable() as $key) {
            $input = $request->input($key);
            if (is_null($input) && $this->modelInstance->hasCast($key, 'boolean')) {
                $input = false;
            }
            $modelAttributes[$key] = $input;
        }

        return $modelAttributes;
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
     * @param array $data
     * @param int $status
     * @param array $headers
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    protected function render(array $data = [], $status = 200, array $headers = [])
    {
        $html = view($this->template, $data, $this->mergeData)->render();

        return response($html, $status, $headers);
    }

    /**
     * @return string
     */
    protected function getMorphType()
    {
        return snake_case(str_replace('\\', '', class_basename($this->morphModel)));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function allMorphModels()
    {
        return forward_static_call([$this->morphModel, 'allByType'], $this->type);
    }

    /**
     * @param string $slug
     *
     * @return Model
     */
    protected function findMorphModel(string $slug)
    {
        return forward_static_call([$this->morphModel, 'findBySlug'], $slug);
    }

    /**
     * @param array $items
     *
     * @return $this
     */
    protected function pushToDefaults(array $items)
    {
        $this->mergeData = array_merge($this->mergeData, $items);

        return $this;
    }

    /**
     * @return $this
     * @throws ModelNotFoundException
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

            $this->setTypeAndFormAction()->setTypeName()->setModelInstance();
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
        $formHeader = ($action === 'update' ? ucfirst($this->formAction) : 'Create').' '.ucfirst($this->type);

        $data = compact('type', 'btnMessage', 'action', 'formHeader');

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
