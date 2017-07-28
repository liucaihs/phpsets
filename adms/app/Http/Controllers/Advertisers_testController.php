<?php

namespace App\Http\Controllers;
use App\Models\Advputon;
use App\Models\ClickLog;
use App\Models\Setting;
use Validator;
use App\Common\Regex;
use App\Models\Advertising;
use App\Models\Advertiser;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Log;
class Advertisers_testController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $req)
    {
        return view('advertisers_test.index', []);
    }

    public function getTest(Request $req)
    {
        $data = $req->all();

        $id = $data['id'];
        $putOn =  Advputon::where('id',intval($id))->first();

        if (empty($putOn)) {
            $this->respJsonResult(0, '参数错误！');
        }

        if (empty($data['ip']) || (empty($data['mac']) && empty($data['idfa'])) ) {
            $this->respJsonResult(0, '参数不够！');
        }
        $advObj =  Advertising::where('id', $putOn->ad_id)->first();


        if ( empty($advObj)) {
            $this->respJsonResult(0, '找不到广告信息！');

        }

        $clickLog = $putOn->toArray();

//        $this->callClickApi($clickLog['adput_sn'] , $data , $req);
        $this->callClickApi2($clickLog['adput_sn'] , $data );
        $wecallbackurl = Setting::getSettingValue('adx_adeff');
//        $wecallbackurl .=  "?s={$clickLog['adput_sn']}&mac={$data['mac']}&ifa={$data['idfa']}";
        $wecallbackurl .=  "?s=" . base64_encode("s={$clickLog['adput_sn']}&mac={$data['mac']}&ifa={$data['idfa']}");
        $callurl = $advObj->owner_apiurl;
        if ( strpos( $callurl, '{ifa}')) {
            $callurl = str_replace('{ifa}' , $data['idfa'] , $callurl);
        }
        if ( strpos( $callurl, '{callback_url}')) {

            $callurl = str_replace('{callback_url}' ,$advObj->urlencode ? urlencode($wecallbackurl) : $wecallbackurl , $callurl);
        }
        if ( strpos( $callurl, '{ip}')) {
            $callurl = str_replace('{ip}' , $data['ip'] , $callurl);
        }
        if ( strpos( $callurl, '{mac}')) {
            $callurl = str_replace('{mac}' , $data['mac'] , $callurl);
        }
        if (strpos($callurl, '{MAC:}')) {
            $callurl = str_replace('{MAC:}', str_replace("-", ":", strtoupper($data['mac'])), $callurl);
        }

        $this->respJsonResult(1, $callurl);
    }

    protected function callClickApi($adput_sn,$data,$req)
    {
        $order = new ClickLog();
        $order->adput_sn = $adput_sn;
        $order->mac = !empty($data['mac']) ? $data['mac'] : '';
        $order->ifa = $data['idfa'];
        $order->ip = $data['ip'];
        $order->status = 1;
        $order->from_ip =  $req->getClientIp();
        $order->create_time = time();
        $order->raw_data = json_encode($req->all());
        $status = $order->save();
        if ( empty($status)) {
            $this->respJsonResult(0, '生成点击记录失败！');
        }
    }


    protected function callClickApi2($adput_sn,$data)
    {
        $clickurl = Setting::getSettingValue('adx_click');
        $clickurl .= "{$adput_sn}&mac={$data['mac']}&ifa={$data['idfa']}&ip={$data['ip']}";
        Log::info($clickurl);
        $response =  $this->Api_Request($clickurl);

        return ;
    }
    /*
     * HTTP请求
     */
    protected function Api_Request($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }
}