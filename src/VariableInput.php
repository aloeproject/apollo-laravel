<?php
/**
 * Created by PhpStorm.
 * User: lkboy
 * Date: 2019/6/17
 * Time: 16:26
 */

namespace Sunaloe\ApolloLaravel;


use Illuminate\Support\Facades\Redis;

class VariableInput
{
    private $data = [];
    private $variable = null;

    public function __construct(ApolloVariable $variable)
    {
        $this->getRedisData();
        $this->variable = $variable;
    }

    private function getRedisData()
    {
        $redisKey = config('apollo.data_redis_key');
        $data = Redis::get($redisKey);
        $arr = \json_decode($data, true);
        if (!empty($arr)) {
            $this->data = $arr;
        }
    }

    public function setData()
    {
        $prefix = config("apollo.prefix");
        foreach ($this->data as $key => $val) {
            $key = sprintf("%s%s", $prefix, $key);
            $this->variable->setEnvironmentVariable($key, $val);
        }
    }
}