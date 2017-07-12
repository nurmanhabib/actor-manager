<?php

namespace Nurmanhabib\ActorManager\Models;

use Illuminate\Database\Eloquent\Model;
use Nurmanhabib\ActorManager\Contracts\ActorModel;
use Nurmanhabib\ActorManager\Models\Traits\ActorModelTrait;

class Profile extends Model implements ActorModel
{
    use ActorModelTrait;

    protected $guarded = [];
    // protected $actorAs = 'test';
}
