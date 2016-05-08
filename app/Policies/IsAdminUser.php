<?php

namespace Garble\Policies;

use Garble\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IsAdminUser
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}
