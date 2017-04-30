<?php

namespace Nurmanhabib\ActorManager;

use Illuminate\Support\ServiceProvider;
use Nurmanhabib\ActorManager\Contracts\GroupModel;
use Nurmanhabib\ActorManager\Contracts\UserModel;

class ActorManagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootConfig();
        $this->bootMigrations();
    }

    protected function bootConfig()
    {
        $this->publishes([
            __DIR__.'/../config/actor-manager.php' => config_path('actor-manager.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__.'/../config/actor-manager.php', 'actor-manager'
        );
    }

    protected function bootMigrations()
    {
        $this->publishes([
            __DIR__.'/../config/actor-manager.php' => config_path('actor-manager.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    public function register()
    {
        $this->app->bind(UserModel::class, function ($app) {
            return new $app['config']->get('actor-manager.models.user');
        });

        $this->app->bind(GroupModel::class, function ($app) {
            return new $app['config']->get('actor-manager.models.group');
        });
    }
}
