<?php
/**
 * User: cailiu
 * Date: 2017/6/28
 * Time: 14:43
 */
namespace proxy;

class KdlProxy extends CommProxy
{
    protected $reqUrl = 'http://dps.kuaidaili.com/api/getdps';
    public function __construct()
    {
    }

    /*
     * get enable ip lists
     * parm string $orderNo
     * parm int $num  ip个数
     * parm int $ut  有效时长 1 10 minute ,2 30 , 3 60 ,4 120
     * return array
     */
    public function getIpLists($orderNo , $num = 10 , $ut = 1)
    {
        if (empty($num)) {
            $num=1;
        }
        $url = $this->reqUrl;
        $param = array(
            'orderid' => $orderNo ,//'969025122866284',
            'num' => $num,
            'ut' => $ut,
            'f_loc' => 1, //地区
            'format' => 'json',
            'sep' => 1,
        );
        $qs = http_build_query($param);
        $url = $url.'?'.$qs;
        $json = self::http_get($url);
        $this->log_msg($json);
        $json_arr = json_decode($json, true);

        if ('0' != strval($json_arr['code'])) {
            return null;
        }

        $ori_data = $json_arr['data']['proxy_list'];
        $data = array();
        foreach($ori_data as $str){
            //"115.221.116.181:27235,浙江省温州市"
            $arr = explode(',', $str);

            $data[] = $arr[0];
        }
        return $data;
    }
}