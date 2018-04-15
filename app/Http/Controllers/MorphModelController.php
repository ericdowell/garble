<?php

namespace Garble\Http\Controllers;

use Throwable;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route as CurrentRoute;
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
     * @var bool
     */
    protected $grouped = false;

    /**
     * @var string
     */
    protected $groupName;

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
        $route = sprintf('%s.%s', $this->type, $this->formAction);
        if ($this->grouped) {
            $route = sprintf('%s.%s.%s', $this->getGroupName(), $this->type, $this->formAction);
        }
        $options = compact('route');

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

        $attributes = array_merge($this->beforeStoreModel($request), [
            "{$morphType}_type" => $this->type,
            "{$morphType}_id" => $model->id,
        ]);

        $instance = forward_static_call([$this->morphModel, 'create'], $attributes);

        if (! $instance instanceof Model) {
            return redirect()->back()->withInput()->withErrors('Something went wrong.');
        }

        return $this->redirectToIndex();
    }

    /**
     * @param \Illuminate\Foundation\Http\FormRequest $request
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
     * Display the specified resource.
     *
     * @param  mixed $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function show($id)
    {
        ${$this->type} = $instance = $this->findMorphModel($id);

        return $this->render(compact($this->type, 'instance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  mixed $id
     *
     * @return Response
     * @throws Throwable
     */
    public function edit($id): Response
    {
        $instance = $this->findMorphModel($id);
        $route = sprintf('%s.%s', $this->type, $this->formAction);
        if ($this->grouped) {
            $route = sprintf('%s.%s.%s', $this->getGroupName(), $this->type, $this->formAction);
        }
        $options = [
            'route' => [$route, $instance->getKey()],
            'method' => 'put',
        ];

        return $this->render(compact('instance', 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FormRequest $request
     * @param  mixed $id
     *
     * @return RedirectResponse
     */
    public function updateModel(FormRequest $request, $id): RedirectResponse
    {
        $instance = $this->findMorphModel($id);

        $this->beforeModelUpdate($request, $instance);
        $instance->{$this->getMorphType()}->update($this->getModelAttributes($request));

        return $this->redirectToIndex();
    }

    /**
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param Model $instance
     */
    protected function beforeModelUpdate(FormRequest $request, Model $instance)
    {
        $slugInput = $request->input('slug');
        if ($slugInput != $instance->slug) {
            $instance->update(['slug' => $slugInput]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed $id
     *
     * @return RedirectResponse
     * @throws Throwable
     */
    public function destroy($id): RedirectResponse
    {
        $instance = $this->findMorphModel($id);
        /** @var Model $model */
        $model = $instance->{$this->getMorphType()};

        $model->delete();
        $instance->delete();

        return $this->redirectToIndex();
    }

    /**
     * @param FormRequest $request
     *
     * @return array
     */
    protected function getModelAttributes(FormRequest $request): array
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
     * @return RedirectResponse
     */
    protected function redirectToIndex(): RedirectResponse
    {
        return redirect()->route($this->type.'.index');
    }

    /**
     * @return CurrentRoute
     */
    protected function route(): CurrentRoute
    {
        return $this->route;
    }

    /**
     * @param array $data
     * @param int $status
     * @param array $headers
     *
     * @return Response
     * @throws Throwable
     */
    protected function render(array $data = [], $status = 200, array $headers = []): Response
    {
        $html = view($this->template, $data, $this->mergeData)->render();

        return response($html, $status, $headers);
    }

    /**
     * @return string
     */
    protected function getGroupName(): string
    {
        return $this->groupName ?? $this->getMorphType();
    }

    /**
     * @return string
     */
    protected function getMorphType(): string
    {
        return snake_case(str_replace('\\', '', class_basename($this->morphModel)));
    }

    /**
     * @return Collection
     */
    protected function allMorphModels(): Collection
    {
        $morphType = $this->getMorphType();

        return forward_static_call([$this->morphModel, 'where'], "{$morphType}_type", str_singular($this->type))->get();
    }

    /**
     * @param mixed $id
     *
     * @return Model
     */
    protected function findMorphModel($id): Model
    {
        return forward_static_call([$this->morphModel, 'with'], 'user')->findOrFail($id);
    }

    /**
     * @param array $items
     *
     * @return $this
     */
    protected function pushToDefaults(array $items): MorphModelController
    {
        $this->mergeData = array_merge($this->mergeData, $items);

        return $this;
    }

    /**
     * @return $this
     * @throws ModelNotFoundException
     */
    protected function setupModel(): MorphModelController
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
    protected function setupDefaults(): MorphModelController
    {
        $this->route = Route::current();
        if (method_exists($this->route, 'getName') && ! empty($this->route->getName())) {
            $this->template = $this->route()->getName();

            $this->setTypeAndFormAction()->setTypeName()->setModelInstance();
        }

        return $this;
    }

    /**
     * @return string
     */
    protected function getTypeActionStr(): string
    {
        $morphTypePos = stripos($this->template, $this->getMorphType());
        if ($morphTypePos === false) {
            return $this->template;
        }
        $this->grouped = true;

        return ltrim(substr($this->template, $morphTypePos), '.');
    }

    /**
     * @return $this
     */
    protected function setTypeAndFormAction(): MorphModelController
    {
        list($type, $action) = explode('.', $this->getTypeActionStr());

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
    protected function setTypeName(): MorphModelController
    {
        $this->typeName = $typeName = str_plural(ucfirst($this->type));

        return $this->pushToDefaults(compact('typeName'));
    }

    /**
     * @return $this
     */
    protected function setModelInstance(): MorphModelController
    {
        $this->modelInstance = $instance = new $this->model();

        return $this->pushToDefaults(compact('instance'));
    }
}
