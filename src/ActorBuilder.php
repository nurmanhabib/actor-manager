<?php

namespace Nurmanhabib\ActorManager;

use Illuminate\Contracts\Hashing\Hasher;
use Nurmanhabib\ActorManager\Contracts\ActorModel;
use Nurmanhabib\ActorManager\Contracts\RoleModel;
use Nurmanhabib\ActorManager\Contracts\UserModel;
use Nurmanhabib\ActorManager\Exceptions\UnfulfilledRequireException;

class ActorBuilder
{
    protected $actor;
    protected $user;
    protected $hasher;

    protected $attributes = [];
    protected $email;
    protected $username;
    protected $password;

    protected $roles = [];
    protected $permission = [];
    protected $abilities = [];

    public function __construct(ActorModel $actor = null)
    {
        $this->setActor($actor);
    }

    public function setActor(ActorModel $actor)
    {
        return $this->actor = $actor;
    }

    public function setHasher(Hasher $hasher)
    {
        return $this->hasher = $hasher;
    }

    public function setUser(UserModel $user)
    {
        return $this->user = $user;
    }

    public function setAttributes($attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function addRole(RoleModel $role)
    {
        $this->roles[] = $role;
    }

    public function addRoles($roles)
    {
        foreach ($roles as $role) {
            $this->addRole($role);
        }
    }

    public function build()
    {
        $this->buildActor();

        if ($this->hasUser()) {
            $this->buildUser();
            $this->attachRoles();
        }

        return $this->actor->load('user');
    }

    protected function buildActor()
    {
        $this->requiredActor();

        $this->actor->fill($this->attributes);
        $this->actor->save();
    }

    protected function buildUser()
    {
        $this->requiredHasher();
        $this->requiredEmail();
        $this->requiredUsername();
        $this->requiredPassword();

        $this->user->email = $this->email;
        $this->user->username = $this->username;
        $this->user->password = $this->hasher->make($this->password);
        $this->user->associateActor($this->actor);
        $this->user->save();
    }

    protected function attachRoles()
    {
        foreach ($this->roles as $role) {
            $this->attachUserRole($this->user, $role);
        }
    }

    protected function attachUserRole(UserModel $user, RoleModel $role)
    {
        $user->attachRole($role);
    }

    protected function hasUser()
    {
        return !$this->ignoreUser();
    }

    protected function ignoreUser()
    {
        return is_null($this->user);
    }

    protected function requiredHasher()
    {
        $this->required('hasher');
    }

    protected function requiredActor()
    {
        $this->required('actor');
    }

    protected function requiredUser()
    {
        $this->required('user');
    }

    protected function requiredEmail()
    {
        $this->required('email');
    }

    protected function requiredUsername()
    {
        $this->required('username');
    }

    protected function requiredPassword()
    {
        $this->required('password');
    }

    protected function required($property)
    {
        if (is_null($this->{$property})) {
            $this->throwableRequired($property);
        }
    }

    protected function throwableRequired($property)
    {
        throw new UnfulfilledRequireException($property);
    }
}
