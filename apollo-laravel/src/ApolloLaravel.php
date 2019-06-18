<?php
/**
 * Created by PhpStorm.
 * User: lkboy
 * Date: 2019/6/6
 * Time: 17:45
 */

namespace Sunaloe\ApolloLaravel;


use Org\Multilinguals\Apollo\Client\ApolloClient;
use Sunaloe\ApolloLaravel\Contracts\Operate;

class ApolloLaravel
{
    private $operate = null;

    public function __construct(Operate $operate)
    {
        $this->operate = $operate;
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


        $redisKey = config('apollo.data_redis_key');
        $this->operate->set($redisKey,json_encode($newConfig));
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

    public static function use($connection)
    {
        if (is_null($config = config("database.redis.{$connection}"))) {
            throw new \Exception("Redis connection [{$connection}] has not been configured.");
        }

        config(['database.redis.apollo' => array_merge($config, [
            'options' => ['prefix' => config('apollo.redis_prefix') ?: 'apollo:'],
        ])]);
    }

}