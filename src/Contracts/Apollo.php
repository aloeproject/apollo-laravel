<?php
/**
 * Created by PhpStorm.
 * User: lkboy
 * Date: 2019/7/2
 * Time: 11:02
 */

namespace Sunaloe\ApolloLaravel\Contracts;


interface Apollo
{
    /**
     * 重置env 变量
     * @return void mixed
     */
    public function resetConfig();
}