<?php

namespace Sunaloe\ApolloLaravel;


use Illuminate\Contracts\Redis\Factory as RedisFactory;
use Sunaloe\ApolloLaravel\Contracts\Operate;

class RedisOperate implements Operate
{

    private $redis;


    public function __construct(RedisFactory $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @param $key
     * @return mixed|string
     */
    public function get($key)
    {
        $result = $this->connection()->get($key);

        return $result;
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value)
    {
        return $this->connection()->set($key, $value);
    }

    public function connection()
    {
        return $this->redis->connection('apollo');
    }
}