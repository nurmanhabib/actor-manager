<?php

namespace Nurmanhabib\ActorManager\Permissions;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;

class PermissionContext implements Arrayable
{
    protected $model;
    protected $name;

    public function __construct(Model $model, $name)
    {
        $this->model = $model;
        $this->name = $name;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getName()
    {
        return $this->name;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'model' => $this->model,
        ];
    }
}
