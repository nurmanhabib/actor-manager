<?php

namespace Nurmanhabib\ActorManager;

use Nurmanhabib\ActorManager\Contracts\AbilityModel;
use Nurmanhabib\ActorManager\Contracts\RoleModel;
use Nurmanhabib\ActorManager\Permissions\PermissionCollection;
use Nurmanhabib\ActorManager\Permissions\PermissionItem;

class RoleManager
{
    protected $role;
    protected $ability;
    protected $abilities;
    protected $permissions;
    protected $resourceDefaults = ['create', 'view', 'edit', 'delete'];

    public function __construct(RoleModel $role, AbilityModel $ability)
    {
        $this->role = $role;
        $this->ability = $ability;
        $this->abilities = $ability->all();
        $this->permissions = new PermissionCollection;
    }

    public function setName($name)
    {
        $this->role->name = $name;
    }

    public function canResource($name)
    {
        foreach ($this->resourceDefaults as $resource) {
            $this->can($resource . '-' . $name);
        }
    }

    public function cannotResource($name)
    {
        foreach ($this->resourceDefaults as $resource) {
            $this->cannot($resource . '-' . $name);
        }
    }

    public function can($abilityName)
    {
        if ($ability = $this->findAbility($abilityName)) {
            $this->addPermission($ability, true);
        }
    }

    public function cannot($abilityName)
    {
        if ($ability = $this->findAbility($abilityName)) {
            $this->addPermission($ability, false);
        }
    }

    protected function findAbility($abilityName)
    {
        return $this->abilities->first(function (AbilityModel $ability) use ($abilityName) {
            return $ability->getName() === $abilityName;
        });
    }

    public function addPermission(AbilityModel $ability, $granted)
    {
        $this->role->attachAbility($ability, $granted);
    }

    public function removePermission(AbilityModel $ability)
    {
        $this->role->detachAbility($ability);
    }

    public function get()
    {
        return $this->permissions->get();
    }
}
