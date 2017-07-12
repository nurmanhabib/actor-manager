<?php

namespace Nurmanhabib\ActorManager;

use Illuminate\Support\Collection;
use Nurmanhabib\ActorManager\Contracts\AbilityModel;
use Nurmanhabib\ActorManager\Exceptions\AlreadyExistsAbilitiesException;

class AbilityBuilder
{
    protected $ability;
    protected $abilities;
    protected $existsAbilities;
    protected $resourceDefaults = ['create', 'view', 'edit', 'delete'];

    public function __construct(AbilityModel $ability)
    {
        $this->ability = $ability;
        $this->abilities = new Collection;
        $this->existsAbilities = new Collection;
    }

    public function addResource($name)
    {
        foreach ($this->resourceDefaults as $resource) {
            call_user_func([$this, 'add' . ucfirst($resource)], $name);
        }
    }

    public function addCreate($name)
    {
        $this->add('create-' . $name);
    }

    public function addView($name)
    {
        $this->add('view-' . $name);
    }

    public function addEdit($name)
    {
        $this->add('edit-' . $name);
    }

    public function addDelete($name)
    {
        $this->add('delete-' . $name);
    }

    public function add($abilityName)
    {
        if (!$this->find($abilityName)) {
            $this->abilities->push($abilityName);
        }
    }

    public function find($abilityName)
    {
        return $this->abilities->first(function ($ability) use ($abilityName) {
            return $ability === $abilityName;
        });
    }

    public function get()
    {
        return $this->abilities->all();
    }

    public function build()
    {
        if ($existsAbilities = $this->loadExistsAbilities()) {
            $this->throwableAlreadyExistsAbilities($this->existsAbilities);
            return;
        }

        return $this->getNotExistsAbilities()->map(function ($name) {
            return $this->ability->newQuery()->create(compact('name'));
        });
    }

    protected function getNotExistsAbilities()
    {
        if (!$this->hasExistsAbilities()) {
            return $this->abilities;
        }

        return $this->abilities->reject(function ($abilityName) {
            return $this->inExistsAbilities($abilityName);
        });
    }

    protected function inExistsAbilities($abilityName)
    {
        return in_array($abilityName, $this->getExistsAbilities());
    }

    protected function hasExistsAbilities()
    {
        return $this->existsAbilities->count() > 0;
    }

    protected function getExistsAbilities()
    {
        return $this->existsAbilities->map(function (AbilityModel $ability) {
            return $ability->getName();
        })->toArray();
    }

    protected function loadExistsAbilities()
    {
        $existsAbilities = $this->ability->newQuery()
            ->whereIn('name', $this->abilities->toArray())
            ->get();

        return $existsAbilities->count() > 0 ? $this->existsAbilities = $existsAbilities : null;
    }

    protected function throwableAlreadyExistsAbilities($abilities)
    {
        throw new AlreadyExistsAbilitiesException($abilities);
    }
}
