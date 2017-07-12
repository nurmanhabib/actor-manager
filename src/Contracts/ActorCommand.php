<?php

namespace Nurmanhabib\ActorManager\Contracts;

use Nurmanhabib\ActorManager\ActorManager;

interface ActorCommand
{
    public function execute(ActorManager $manager, ActorModel $actor);
}
