<?php

namespace Nurmanhabib\ActorManager\Models\Traits;

trait WithoutTimestamps
{
    public function usesTimestamps()
    {
        return false;
    }
}
