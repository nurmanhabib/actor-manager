<?php

namespace Nurmanhabib\ActorManager\Models;

use Illuminate\Database\Eloquent\Model;
use Nurmanhabib\ActorManager\Contracts\RoleModel;
use Nurmanhabib\ActorManager\Models\Traits\RoleModelTrait;

class Role extends Model implements RoleModel
{
    use RoleModelTrait;

    protected $guarded = [];
}
