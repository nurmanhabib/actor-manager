<?php

namespace Nurmanhabib\ActorManager\Models\Traits;

use Nurmanhabib\ActorManager\Contracts\GroupModel;

trait RoleModelTrait
{
    use HasAbilityTrait;
    use WithoutTimestamps;

    public function getName()
    {
        return $this->name;
    }

    public function users()
    {
        return $this->belongsToMany(config('actor-manager.models.user'));
    }
}
