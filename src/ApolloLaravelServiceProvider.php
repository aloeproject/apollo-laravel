<?php


namespace Sunaloe\ApolloLaravel;


use Illuminate\Cache\CacheManager;
use Illuminate\Support\ServiceProvider;

class ApolloLaravelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $input = new InputVar($this->app['apollo.cache']);
        $input->input();
    }


    public function register()
    {
        $this->configure();
        $this->registerServices();
        $this->registerCommands();
    }

    protected function registerServices()
    {

        $this->app->singleton('apollo.cache', function ($app) {
            $app['config']->set('cache', config('apollo.cache'));
            $obj = new CacheManager($app);
            return $obj;
        });

        $this->app->singleton('apollo.service', function ($app) {
            return new ApolloService($app['apollo.cache']);
        });


        $this->app->singleton('apollo.variable', function () {
            return new ApolloVariable();
        });
    }

    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/apollo.php', 'apollo'
        );
        ApolloService::useConfig(config('apollo.redis_use'));
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([Console\WorkCommand::class]);
            return;
        }
    }
}