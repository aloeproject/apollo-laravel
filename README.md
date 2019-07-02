# laravel 接入携程 [Apollo](https://github.com/ctripcorp/apollo) 


## 概述

Apollo（阿波罗）是携程框架部门研发的分布式配置中心，能够集中化管理应用不同环境、不同集群的配置，配置修改后能够实时推送到应用端，并且具备规范的权限、流程治理等特性，适用于微服务配置管理场景。
此插件让 laravel 框架方便的接入 apollo

## 运行环境
- PHP 7.0
- laravel 5.7
- lumen 5.7


## 安装方法 

composer require sunaloe/apollo-laravel

### laravel

- 配置引入
把 /apollo-laravel/config/apollo.php 拷贝放到配置目录

- 服务提供者引入

```php
 'providers' => [
        \Sunaloe\ApolloLaravel\ApolloLaravelServiceProvider::class,
    ],
```

### lumen

- 配置引入
把 /apollo-laravel/config/apollo.php 拷贝放到配置目录

```php
    $app->configure('apollo');
```

- 服务提供者引入


```php
    $app->register(\Illuminate\Redis\RedisServiceProvider::class);
    $app->register(\Sunaloe\ApolloLaravel\ApolloServiceProvider::class);
```


## 使用

- apollo 配置监控

#### 配置work的常驻进程
```php
php artisan apollo:work
```

#### 使用配置
```php
env('apollo:配置名')
```

### 重新更新env变量
```php
\Sunaloe\ApolloLaravel\Facades\Apollo::resetConfig();
```

## License

- MIT


