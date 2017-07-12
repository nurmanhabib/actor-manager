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
        $filename = 'create_actor_manager_tables.php';
        $dateFormatted = date('Y_m_d_His_');
        $from = __DIR__.'/../database/migrations/000_00_00_000000_' . $filename;
        $to = base_path('database/migrations/' . $dateFormatted . $filename);

        $this->publishes([$from => $to], 'migrations');
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
