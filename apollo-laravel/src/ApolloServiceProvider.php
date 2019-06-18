<?php
/**
 * Created by PhpStorm.
 * User: lkboy
 * Date: 2019/6/6
 * Time: 19:54
 */

namespace Sunaloe\ApolloLaravel;


use Illuminate\Support\ServiceProvider;

class ApolloServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (!$this->app->runningInConsole()) {
            $input = new VariableInput($this->app['apollo.variable'], $this->app['apollo.operate']);
            $input->setData();
        }
    }


    public function register()
    {
        $this->configure();
        $this->registerServices();
        $this->registerCommands();
    }

    protected function registerServices()
    {
        $this->app->singleton('apollo.operate', function ($app) {
            return new RedisOperate($app['redis']);
        });

        $this->app->singleton('apollo.laravel', function ($app) {
            return new ApolloLaravel($app['apollo.operate']);
        });


        $this->app->singleton('apollo.variable', function () {
            return new ApolloVariable();
        });


    }

    protected function configure()
    {
        $this->app->configure('apollo');
        $this->mergeConfigFrom(
            __DIR__ . '/../config/apollo.php', 'apollo'
        );

        ApolloLaravel::use(config('apollo.redis_use'));
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([Console\WorkCommand::class]);
            return;
        }
    }
}