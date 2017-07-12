<?php

namespace Nurmanhabib\ActorManager\Permissions;

use Illuminate\Contracts\Support\Arrayable;
use Nurmanhabib\ActorManager\Contracts\AbilityModel;

class PermissionItem implements Arrayable
{
    protected $ability;
    protected $granted;
    protected $context;

    public function __construct(AbilityModel $ability, $granted)
    {
        $this->ability = $ability;
        $this->context = null;

        $this->setGranted($granted);
    }

    public function getName()
    {
        return $this->ability->getName();
    }

    public function getContext()
    {
        return $this->context;
    }

    public function getAbility()
    {
        return $this->ability;
    }

    public function setContext(PermissionContext $context = null)
    {
        $this->context = $context;
    }

    public function setRejected($rejected = true)
    {
        $this->setGranted(!$rejected);
    }

    public function setGranted($granted = true)
    {
        $this->granted = (bool) $granted;
    }

    public function isRejected()
    {
        return !$this->isGranted();
    }

    public function isGranted()
    {
        return $this->granted ? true : false;
    }

    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'granted' => $this->isGranted(),
            'context' => $this->getContext() ? $this->getContext()->getName() : null,
        ];
    }
}
