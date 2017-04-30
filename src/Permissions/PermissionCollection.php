<?php

namespace Nurmanhabib\ActorManager\Permissions;

use Illuminate\Support\Collection;
use Nurmanhabib\ActorManager\AbilityItem;
use Nurmanhabib\ActorManager\Contracts\AbilityModel;
use Nurmanhabib\ActorManager\Contracts\RoleModel;
use Nurmanhabib\ActorManager\Contracts\UserModel;
use Nurmanhabib\ActorManager\Permissions\Context\OwnedContext;
use Nurmanhabib\ActorManager\Permissions\Context\RoleContext;

class PermissionCollection
{
    protected $permissions;

    public function __construct()
    {
        $this->reset();
    }

    public function addFromRole(RoleModel $role)
    {
        $results = [];
        $context = new RoleContext($role);

        foreach ($role->abilities as $ability) {
            $results = $this->add($ability, $ability->pivot->granted, $context);
        }

        return $results;
    }

    public function addOwned(UserModel $user, AbilityModel $ability, $granted)
    {
        return $this->addOverwrite($ability, $granted, new OwnedContext($user));
    }

    public function addOverwrite(
        AbilityModel $ability,
        $granted,
        PermissionContext $context = null
    ) {
        return $this->add($ability, $granted, $context, true);
    }

    public function add(
        AbilityModel $ability,
        $granted,
        PermissionContext $context = null,
        $overwrite = false
    ) {
        if ($permission = $this->find($ability->getName())) {
            return $this->updateExisting($permission, $granted, $context, $overwrite);
        }

        $permission = new PermissionItem($ability, $granted);
        $permission->setContext($context);

        $this->permissions->push($permission);

        return $permission;
    }

    protected function updateExisting(
        PermissionItem $permission,
        $granted,
        PermissionContext $context = null,
        $overwrite = false
    ) {
        if (($permission->isRejected() && $granted) || $overwrite) {
            $permission->setContext($context);
            $permission->setGranted($granted);
        }

        return $permission;
    }

    public function onlyRejected()
    {
        return $this->permissions->filter(function (PermissionItem $permission) {
            return $permission->isRejected();
        });
    }

    public function onlyGranted()
    {
        return $this->permissions->filter(function (PermissionItem $permission) {
            return $permission->isGranted();
        });
    }

    public function find($permissionName)
    {
        return $this->permissions->first(function (PermissionItem $permission) use ($permissionName) {
            return $permission->getName() === $permissionName;
        });
    }

    public function isAbleTo($name)
    {
        $permission = $this->find($name);

        return $permission ? $permission->isGranted() : false;
    }

    public function reset()
    {
        $this->permissions = new Collection;
    }

    public function get()
    {
        return $this->permissions;
    }
}
