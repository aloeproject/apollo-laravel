<?php
/**
 * Created by PhpStorm.
 * User: lkboy
 * Date: 2019/7/2
 * Time: 11:15
 */

namespace Sunaloe\ApolloLaravel;



use Sunaloe\ApolloLaravel\Contracts\Apollo;

class ApolloManager implements Apollo
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function resetConfig()
    {
        $input = new InputVar($this->app['apollo.cache']);
        $input->input();
    }

}