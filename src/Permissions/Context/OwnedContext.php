<?php

namespace Nurmanhabib\ActorManager\Permissions\Context;

use Nurmanhabib\ActorManager\Contracts\UserModel;
use Nurmanhabib\ActorManager\Permissions\PermissionContext;

class OwnedContext extends PermissionContext
{
    public function __construct(UserModel $user)
    {
        parent::__construct($user, 'owned');
    }
}
