<?php

namespace Nurmanhabib\ActorManager\Models\Traits;

use ReflectionClass;

trait ActorModelTrait
{
    public function getActorAs()
    {
        $reflection = new ReflectionClass($this);

        return $reflection->hasProperty('actorAs') ?
            $this->actorAs : strtolower($reflection->getShortName());
    }

    public function hasUser()
    {
        return $this->user ? true : false;
    }

    public function user()
    {
        return $this->morphOne(config('actor-manager.models.user'), 'actorable');
    }
}
