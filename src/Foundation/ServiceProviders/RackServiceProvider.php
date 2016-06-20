<?php
/**
 * Created by PhpStorm.
 * User: jacob
 * Date: 16/6/20
 * Time: 下午3:26
 */

namespace EasyWeChat\Foundation\ServiceProviders;


use EasyWeChat\Card\StorageRack;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
class RackServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['rack'] = function ($pimple) {
            return new StorageRack($pimple['access_token']);
        };
    }
}