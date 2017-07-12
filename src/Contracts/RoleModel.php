<?php

namespace Nurmanhabib\ActorManager\Contracts;

interface RoleModel
{
    public function getName();
    public function attachAbility(AbilityModel $ability, $granted = true);
    public function detachAbility(AbilityModel $ability);
    public function users();
    public function abilities();
}
