<?php

/**
 * Created by PhpStorm.
 * User: jacob
 * Date: 16/6/17
 * Time: 上午10:21
 * 接口调用顺序：

1.调用上传LOGO接口将商户图标上传微信服务器并获取logo_url，用于创建卡券。

2.调用门店管理接口获取门店 ID，设置卡券适用门店。

3.调用获取颜色列表接口，设置卡券背景色。

4.调用创建卡券接口，设置卡券相应信息，获取卡券ID，并标注可领取的库存。
 */
namespace EasyWeChat\Card;
use EasyWeChat\Core\AbstractAPI;
class Card extends AbstractAPI
{

    const API_CREATE = 'https://api.weixin.qq.com/card/create';
    const API_ALL ='https://api.weixin.qq.com/card/batchget';
    const API_DELETE = 'https://api.weixin.qq.com/card/delete';

    const API_POILIST = 'https://api.weixin.qq.com/cgi-bin/poi/getpoilist';
    const API_LOGO = 'https://api.weixin.qq.com/cgi-bin/media/uploadimg';
    const API_TEST = 'https://api.weixin.qq.com/card/testwhitelist/set';

    /**
     * 获取所有卡券列表
     * @param int $offset 偏移
     * @param int $count 一次性查询总数,小于等于50
     * @param string $status_list 查询指定状态的卡券
     * @return \EasyWeChat\Support\Collection
     */
    public function all($offset = 0 , $count = 50 , $status_list = 'CARD_STATUS_VERIFY_OK')
    {
        $params =[
            'offset' => $offset,
            'count'  =>$count,
            'status_list' =>$status_list
        ];

        return $this->parseJSON('json', [self::API_ALL, $params]);
    }

    /**
     * 应用第一步,上传logo
     * @param $buffer 上传文件的数据流
     * @return \EasyWeChat\Support\Collection
     */
    public function setLogo($buffer)
    {
        $params =[
          'buffer' => $buffer
        ];

        return $this->parseJSON('upload',[self::API_LOGO , $params ]);
    }

    /**
     * 获取所有门店列表
     * @param int $offset
     * @param int $count
     * @return \EasyWeChat\Support\Collection
     */
    public function getPoilist($offset = 0 , $count =50)
    {
        return $this->parseJSON('json',[self::API_POILIST , ['begin' => $offset , 'limit'=> $count] ]);
    }
    
    /**
     * 创建卡券
     * @param $baseinfo 基本卡券数据
     * @param $detail   卡券详情
     * @param $map      导览图
     * @param string $type 门票类型 默认会议门票类型,详情见微信官方文档 暂时只支持会议票
     * @return \EasyWeChat\Support\Collection
     */
    public function create( $baseinfo = [] , $detail ='' , $map ='')
    {
        $params =[
            "card" =>[
                'card_type' => 'MEETING_TICKET',
                "meeting_ticket" =>[
                    "base_info"=>$baseinfo,
                    "meeting_detail"=>$detail
                ]
            ]
        ];
        return $this->parseJSON('json',[self::API_CREATE,$params]);
    }

    /**
     * 设置测试白名单,最多10个
     * 格式如下
     * $params = [
     *   'openid' => ['xxx'],
     *   'username'=>['xxx']
     *   ];
     * @param array $params
     * @return \EasyWeChat\Support\Collection
     */
    public function setTests($params = [])
    {
        return $this->parseJSON('json',[self::API_TEST,$params]);
    }
}