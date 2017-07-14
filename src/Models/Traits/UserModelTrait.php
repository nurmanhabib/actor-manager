<?php

namespace Nurmanhabib\ActorManager\Models\Traits;

use Nurmanhabib\ActorManager\ActorManager;
use Nurmanhabib\ActorManager\Contracts\ActorModel;
use Nurmanhabib\ActorManager\Contracts\RoleModel;

trait UserModelTrait
{
    use HasAbilityTrait;

    public function associateActor(ActorModel $actor)
    {
        $this->actor()->associate($actor);
    }

    public function attachRole(RoleModel $role)
    {
        $this->roles()->syncWithoutDetaching($role);
    }

    public function detachRole(RoleModel $role)
    {
        $this->roles()->detach($role);
    }

    public function isAbleTo($ability)
    {
        return $this->getActorManager()->isAbleTo($ability);
    }

    public function getActorManager()
    {
        return new ActorManager($this->actor);
    }

    public function actor()
    {
        return $this->morphTo('actorable');
    }

    public function roles()
    {
        return $this->belongsToMany(
            config('actor-manager.models.role'),
            config('actor-manager.pivot_tables.user_role')
        );
    }
}
