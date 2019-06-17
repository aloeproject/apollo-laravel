<?php
/**
 * Created by PhpStorm.
 * User: lkboy
 * Date: 2019/6/6
 * Time: 17:45
 */

namespace Sunaloe\ApolloLaravel;


use Illuminate\Support\Facades\Redis;
use Org\Multilinguals\Apollo\Client\ApolloClient;

class ApolloLaravel
{
    private $server = null;
    private $apolloConfig = [];

    private function getServer()
    {
        $this->server = new ApolloClient(
            config('apollo.server'), config('apollo.appid'), config('apollo.namespaces'));

        $this->server->save_dir(config('apollo.save_dir'));
    }

    public function startCallback()
    {
        $list = glob(config('apollo.save_dir') . DIRECTORY_SEPARATOR . 'apolloConfig.*');

        //全量更新
        $this->updateConfig($list);
    }

    private function updateConfig($fileList)
    {
        $newConfig = [];
        foreach ($fileList as $file) {
            $c = require $file;
            if (is_array($c) && isset($c['configurations'])) {
                $newConfig = array_merge($newConfig, $c['configurations']);
            }
        }

        $this->apolloConfig = $newConfig;

        $redisKey = config('apollo.data_redis_key');

        Redis::set($redisKey, $newConfig);
    }

    public function __construct()
    {
        $this->getServer();
    }

}