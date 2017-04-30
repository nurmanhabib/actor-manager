<?php

namespace Nurmanhabib\ActorManager\Contracts;

interface ActorModel
{
    public function getActorAs();
    public function hasUser();
    public function user();
}
