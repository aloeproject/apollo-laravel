<?php
namespace Sunaloe\ApolloLaravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool resetConfig()
 *
 * @see Sunaloe\ApolloLaravel\ApolloManger
 */

class Apollo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'apollo';
    }
}