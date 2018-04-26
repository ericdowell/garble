<?php

namespace Garble\Http\Controllers;

use Hash;
use Throwable;
use Garble\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Garble\Http\Requests\UserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Model;
use EricDowell\ResourceController\Http\Controllers\ResourceModelController;

class UserController extends ResourceModelController
{
    /**
     * Given a route action (key) set the form action (value).
     *
     * @var array
     */
    protected $actionMap = [
        'password-edit' => 'password-update',
    ];

    /**
     * Name of the affected Eloquent model.
     *
     * @var string
     */
    protected $modelClass = User::class;

    /**
     * Route names of public actions, Auth Middleware are not applied to these.
     *
     * @var array
     */
    protected $publicActions = [];

    /**
     * @var bool
     */
    protected $withUser = false;

    /**
     * @param int $id
     *
     * @return Response
     * @throws Throwable
     */
    public function passwordEdit($id): Response
    {
        return $this->edit($id);
    }

    /**
     * @param UserRequest $request
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function passwordUpdate(UserRequest $request, $id): RedirectResponse
    {
        $user = $this->findModel($id);
        $currentPassword = $request->input('current_password');

        if (! Hash::check($currentPassword, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password provided is incorrect.']);
        }
        $attributes = $request->all();
        $attributes['password'] = Hash::make($attributes['password']);

        $user->update($this->getModelAttributes($user, $attributes, true));

        return $this->finishAction('update');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    {
        return $this->storeModel($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserRequest $request
     * @param  mixed $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, $id): RedirectResponse
    {
        $user = $this->findModel($id);
        $currentPassword = $request->input('current_password');

        if (! Hash::check($currentPassword, $user->password)) {
            return redirect()->back()->withInput()->withErrors(['current_password' => 'Current password provided is incorrect.']);
        }

        return $this->updateModel($request, $id);
    }

    /**
     * Updates attributes based on request for Eloquent Model.
     *
     * @param Request $request
     * @param Model $instance
     *
     * @return bool
     */
    protected function updateAction(Request $request, Model $instance): bool
    {
        return $instance->update($this->getModelAttributes($instance, $request->all(), true)) ?? false;
    }
}