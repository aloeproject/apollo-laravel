<?php
/**
 * Created by PhpStorm.
 * User: lkboy
 * Date: 2019/6/17
 * Time: 14:51
 */

namespace Sunaloe\ApolloLaravel\Console;

use Illuminate\Console\Command;
use Org\Multilinguals\Apollo\Client\ApolloClient;
use Sunaloe\ApolloLaravel\ApolloLaravel;

class WorkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apollo:work';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'apollo 配置更新监听';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new ApolloClient(config('apollo.server'),config('apollo.appid'),config('apollo.namespaces'));

        $apollo = new ApolloLaravel();

        $pid = getmypid();
        echo "start [$pid]\n";

        $client->start($apollo->startCallback);
    }
}