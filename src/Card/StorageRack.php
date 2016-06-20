<?php
/**
 * Created by PhpStorm.
 * User: jacob
 * Date: 16/6/20
 * Time: 下午3:08
 */

namespace EasyWeChat\Card;
use EasyWeChat\Core\AbstractAPI;

class StorageRack extends AbstractAPI
{

    const API_QRCODE = 'https://api.weixin.qq.com/card/qrcode/create';

    public function setQrcode($cardid , $openid)
    {
        $params =[
            'action_name' => 'QR_CARD',
            'action_info' =>[
                'card'  =>[
                    'card_id' => $cardid,
                    'openid'    => $openid,
                    'is_unique_code' => true,
                    'outer_id' =>1
                ]
            ]
        ];
        $this->parseJSON('json',[self::API_QRCODE , $params]);
    }
}