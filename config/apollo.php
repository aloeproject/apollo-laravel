<?php

return [
    /**
     * 配置的存活时间 s
     */
    'expire_time' => 60,

    /**
     * apollo 服务器
     */
    'server' => 'http://127.0.0.1:8081',

    /**
     * apollo 配置appid
     */
    'appid' => 'demo',

    /**
     * 读取的namespace
     */
    'namespaces' => ['application'],

    /**
     * 数据存储的 redis key
     */
    'data_redis_key' => 'sunaloe:laravel_data',

    'data_redis_key_bak' => 'sunaloe:laravel_data_bak',

    /**
     * key 前缀
     */
    'prefix'=>'apollo_'
];
