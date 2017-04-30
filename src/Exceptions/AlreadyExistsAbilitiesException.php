<?php

namespace Nurmanhabib\ActorManager\Exceptions;

use Nurmanhabib\ActorManager\Contracts\AbilityModel;

class AlreadyExistsAbilitiesException extends Exception
{
    protected $abilities;

    public function __construct($abilities)
    {
        $this->abilities = $abilities;

        parent::__construct('Some abilities already exists: ' . implode(', ', $this->toArray()));
    }

    protected function getAbilities()
    {
        return $this->abilities;
    }

    protected function toArray()
    {
        return $this->abilities->map(function (AbilityModel $ability) {
            return $ability->getName();
        })->toArray();
    }
}
