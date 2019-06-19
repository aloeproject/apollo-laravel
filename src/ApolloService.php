<?php


namespace Sunaloe\ApolloLaravel;


use Org\Multilinguals\Apollo\Client\ApolloClient;
use Illuminate\Contracts\Cache\Factory as FactoryContract;
use Sunaloe\ApolloLaravel\Contracts\Operate;

class ApolloService
{
    private $cache;
    
    public function __construct(FactoryContract $cache)
    {
        $this->cache = $cache;
    }

    private function updateConfig($fileList)
    {
        $newConfig = [];
        foreach ($fileList as $file) {
            if (!is_file($file)) {
                throw new \Exception('config file no exists');
            }
            $c = require $file;
            if (is_array($c) && isset($c['configurations'])) {
                $newConfig = array_merge($newConfig, $c['configurations']);
            }
        }

        if (empty($newConfig)) {
            echo "No configuration data\n";
            return;
        }


        $redisKey = config('apollo.data_redis_key');
        $st = $this->cache->set($redisKey,json_encode($newConfig));
        if (!$st) {
            throw new \Exception('cache write fail');
        }
        echo date('c').":update success\n";
    }

    public function getServer()
    {
        $server = new ApolloClient(
            config('apollo.server'), config('apollo.appid'), config('apollo.namespaces'));
        $server->save_dir = config('apollo.save_dir');
        return $server;
    }

    public function startCallback()
    {
        $list = glob(config('apollo.save_dir') . DIRECTORY_SEPARATOR . 'apolloConfig.*');
        $this->updateConfig($list);
    }

    /**
     * @param $connection
     * @throws \Exception
     */
    public static function useConfig($connection)
    {
        if (is_null($config = config("database.redis.{$connection}"))) {
            throw new \Exception("Redis connection [{$connection}] has not been configured.");
        }

        config(['database.redis.apollo' => array_merge($config, [
            'options' => ['prefix' => config('apollo.prefix') ?: 'apollo:'],
        ])]);
    }

}