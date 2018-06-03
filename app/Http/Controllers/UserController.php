<?php

namespace Garble\Http\Controllers;

use Garble\User;
use EricDowell\ResourceController\Http\Controllers\UserController as ResourceUserController;

class UserController extends ResourceUserController
{
    /**
     * Name of the affected Eloquent model.
     *
     * @var string
     */
    protected $modelClass = User::class;
}
