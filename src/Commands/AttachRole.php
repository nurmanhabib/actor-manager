<?php

namespace Nurmanhabib\ActorManager\Commands;

use Nurmanhabib\ActorManager\ActorManager;
use Nurmanhabib\ActorManager\Contracts\ActorCommand;
use Nurmanhabib\ActorManager\Contracts\ActorModel;
use Nurmanhabib\ActorManager\Contracts\RoleModel;

class AttachRole implements ActorCommand
{
    protected $role;

    public function __construct(RoleModel $role)
    {
        $this->role = $role;
    }

    public function execute(ActorManager $manager, ActorModel $actor)
    {
        if ($actor->hasUser()) {
            $actor->user->attachRole($this->role);
            $manager->reloadRolesAndPermission();
        }
    }
}
