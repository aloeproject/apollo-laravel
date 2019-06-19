<?php


namespace Sunaloe\ApolloLaravel;

use Illuminate\Contracts\Cache\Factory as FactoryContract;

class InputVar
{
    private $cache = null;

    public function __construct(FactoryContract $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return array|mixed
     */
    private function getData()
    {
        $ret = [];
        $redisKey = config('apollo.data_redis_key');
        $data = $this->cache->get($redisKey);
        $arr = \json_decode($data, true);
        if (!empty($arr)) {
            $ret = $arr;
        }
        return $ret;
    }

    public function input()
    {
        $ret = $this->getData();
        $prefix = config("apollo.prefix");
        $varObj = app('apollo.variable');
        foreach ($ret as $key => $val) {
            $key = sprintf("%s%s", $prefix, $key);
            $varObj->setEnvironmentVariable($key, $val);
        }
    }
}