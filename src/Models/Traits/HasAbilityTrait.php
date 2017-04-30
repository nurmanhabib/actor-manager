<?php

namespace Nurmanhabib\ActorManager\Models\Traits;

use Nurmanhabib\ActorManager\Contracts\AbilityModel;

trait HasAbilityTrait
{
    public function attachAbility(AbilityModel $ability, $granted = true)
    {
        $this->abilities()->syncWithoutDetaching($ability, compact('granted'));
    }

    public function detachAbility(AbilityModel $ability)
    {
        $this->abilities()->detach($ability);
    }

    public function abilities()
    {
        return $this->morphToMany(
            config('actor-manager.models.ability'),
            'model',
            $this->getPivotTableAbilities()
        )->withPivot('granted');
    }

    protected function getPivotTableAbilities()
    {
        return config('actor-manager.pivot_tables.permissions');
    }
}
