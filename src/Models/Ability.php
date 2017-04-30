<?php

namespace Nurmanhabib\ActorManager\Models;

use Illuminate\Database\Eloquent\Model;
use Nurmanhabib\ActorManager\Contracts\AbilityModel;
use Nurmanhabib\ActorManager\Models\Traits\AbilityModelTrait;

class Ability extends Model implements AbilityModel
{
    use AbilityModelTrait;

    protected $guarded = [];
}
