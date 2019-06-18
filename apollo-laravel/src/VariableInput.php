<?php
/**
 * Created by PhpStorm.
 * User: lkboy
 * Date: 2019/6/17
 * Time: 16:26
 */

namespace Sunaloe\ApolloLaravel;

use Sunaloe\ApolloLaravel\Contracts\Operate;

class VariableInput
{
    private $data = [];
    private $variable = null;
    private $operate;

    public function __construct(ApolloVariable $variable,Operate $operate)
    {
        $this->variable = $variable;
        $this->operate = $operate;
    }

    private function getData()
    {
        $redisKey = config('apollo.data_redis_key');
        $data = $this->operate->get($redisKey);
        $arr = \json_decode($data, true);
        if (!empty($arr)) {
            $this->data = $arr;
        }
    }

    public function setData()
    {
        $this->getData();
        $prefix = config("apollo.prefix");
        foreach ($this->data as $key => $val) {
            $key = sprintf("%s%s", $prefix, $key);
            $this->variable->setEnvironmentVariable($key, $val);
        }
    }
}