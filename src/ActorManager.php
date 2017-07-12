<?php

namespace Nurmanhabib\ActorManager;

use Nurmanhabib\ActorManager\Contracts\ActorCommand;
use Nurmanhabib\ActorManager\Contracts\ActorModel;
use Nurmanhabib\ActorManager\Contracts\RoleModel;
use Nurmanhabib\ActorManager\Permissions\PermissionCollection;

class ActorManager
{
    protected $actor;
    protected $roles;
    protected $permissions;

    public function __construct(ActorModel $actor)
    {
        $this->actor = $actor;
        $this->roles = [];
        $this->permissions = new PermissionCollection;

        if ($this->hasUser()) {
            $this->loadRolesAndPermissions();
        }
    }

    public function reloadRolesAndPermission()
    {
        $this->actor->user->load('roles');
        $this->permissions->reset();

        $this->loadRolesAndPermissions();
    }

    public function loadRolesAndPermissions()
    {
        $this->loadRoles();
        $this->loadPermissions();
        $this->loadOwnedPermissions();
    }

    public function loadRoles()
    {
        $this->roles = $this->actor->user->roles;
    }

    public function loadPermissions()
    {
        foreach ($this->roles as $role) {
            $this->permissions->addFromRole($role);
        }
    }

    public function loadOwnedPermissions()
    {
        $user = $this->actor->user;
        $abilities = $user->abilities;

        foreach ($abilities as $ability) {
            $this->permissions->addOwned($user, $ability, $ability->pivot->granted);
        }
    }

    public function execute(ActorCommand $command)
    {
        $command->execute($this, $this->actor);
    }

    public function getRejectedPermissions()
    {
        return $this->permissions->onlyRejected();
    }

    public function getGrantedPermissions()
    {
        return $this->permissions->onlyGranted();
    }

    public function getPermissions()
    {
        return $this->permissions->get();
    }

    public function hasUser()
    {
        return $this->actor->hasUser();
    }

    public function getUser()
    {
        return $this->actor->user;
    }

    public function hasRole($name)
    {
        return $this->hasRoles([$name]);
    }

    public function hasRoles($names)
    {
        $roles = $this->getRoles()->filter(function ($role) use ($names) {
            return in_array($role->getName(), $names);
        });

        return !$roles->isEmpty();
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function attachRole(RoleModel $role)
    {
        $this->execute(new Commands\AttachRole($role));
    }

    public function detachRole(RoleModel $role)
    {
        $this->execute(new Commands\DetachRole($role));
    }

    public function isAbleTo($abilityName)
    {
        return $this->permissions->isAbleTo($abilityName);
    }

    public function isActorAs($name)
    {
        return $this->getActorAs() === $name;
    }

    public function getActorAs()
    {
        return $this->actor->getActorAs();
    }
}
