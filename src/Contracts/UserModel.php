<?php

namespace Nurmanhabib\ActorManager\Contracts;

interface UserModel
{
    public function associateActor(ActorModel $actor);
    public function attachRole(RoleModel $role);
    public function detachRole(RoleModel $role);
    public function actor();
    public function roles();
    public function abilities();
}
