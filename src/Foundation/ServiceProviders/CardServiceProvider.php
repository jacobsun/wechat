<?php
/**
 * Created by PhpStorm.
 * User: jacob
 * Date: 16/6/17
 * Time: 上午10:25
 */

namespace EasyWeChat\Foundation\ServiceProviders;


use EasyWeChat\Card\Card;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class CardServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['card'] = function ($pimple) {
            return new Card($pimple['access_token']);
        };
    }

}



