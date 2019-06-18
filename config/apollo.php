<?php

return [
    /**
     * apollo 服务器
     */
    'server' => 'http://127.0.0.1:8081',

    /**
     *
     */
    'save_dir'=>'/data/logs/pay_order/',

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
    'data_redis_key' => 'apollo_data',

    /**
     * redis 使用的默认连接
     */
    'redis_use'=>'apollo',

    /**
     * redis 前缀
     */
    'redis_prefix'=>'',
    /**
     * key 前缀
     */
    'prefix'=>'apollo.'
];
