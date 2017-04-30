<?php

namespace Nurmanhabib\ActorManager\Models\Traits;

use Nurmanhabib\ActorManager\Contracts\GroupModel;

trait AbilityModelTrait
{
    use WithoutTimestamps;

    public function getName()
    {
        return $this->name;
    }

    public function users()
    {
        return $this->morphedByMany(
            config('actor-manager.models.user'),
            'model',
            $this->getPivotTableAbilities()
        )->withPivot('granted');
    }

    public function roles()
    {
        return $this->morphedByMany(
            config('actor-manager.models.role'),
            'model',
            $this->getPivotTableAbilities()
        )->withPivot('granted');
    }

    protected function getPivotTableAbilities()
    {
        return 'permissions';
    }
}
