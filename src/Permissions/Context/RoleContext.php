<?php

namespace Nurmanhabib\ActorManager\Permissions\Context;

use Nurmanhabib\ActorManager\Contracts\RoleModel;
use Nurmanhabib\ActorManager\Permissions\PermissionContext;

class RoleContext extends PermissionContext
{
    public function __construct(RoleModel $role)
    {
        parent::__construct($role, 'role:' . $role->getName());
    }
}
