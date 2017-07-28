<?php
/**
 * Created by PhpStorm.
 * User: amdin
 * Date: 2017/5/17
 * Time: 10:15
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;
use App\Advputon;
class AdvertrecvController extends Controller
{
    //获取页面http://af.api.youmi.net/ios/v1/recv?s=786addf4e72LIc6d0p7qDBQmfOO-gbuJ&mac=fc253f122347&ifa=8D8B2869-3C54-4BEA-AD4C-79D1B3A7D288&ip=11.22.33.44
    /*
     * 友商点击广告回调API
     */
    public function clickRecv(Request $req)
    {
        $adput_sn = trim( $req->input('s') );
        $mac = trim( $req->input('mac') );
        $ifa = trim( $req->input('ifa') );
        $ip = trim( $req->input('ip') );

        //判断是否是public IPv4 IP或者是合法的Public IPv6 IP地址
        if(!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
          // it's not valid
            $this->showErro('-401');
        }

        $adPut = Advputon::getAdvPuton($adput_sn);
        if (empty($adPut)) {
            $this->showErro('-201');
        }
        if (empty($ip) || (empty($mac) && empty($ifa)) ) {
            $this->showErro('-301');
        }
        $isMac = $this->checkMacAddr($mac);
        if (!empty($mac) && !$isMac) {
            $this->showErro('-501');
        }

        $order = new Orders();
        $order->adput_sn = $adput_sn;
        $order->mac = $mac;
        $order->ifa = $ifa;
        $order->ip = $ip;
        $order->from_ip =  $req->getClientIp();
        $order->create_time = time();
        $status = $order->save();
        if ($status) {
            $this->showSuccess();
        } else {
            $this->showErro('');
        }

    }

    /*
     * 广告主激活回调API
     */
    public function adeffRecv(Request $req)
    {
        $adput_sn = trim( $req->input('s') );
        $mac = trim( $req->input('mac') );
        $ifa = trim( $req->input('ifa') );

        $condition['adput_sn'] = $adput_sn;
        $adPut = Advputon::getAdvPuton($adput_sn);
        if (empty($adPut)) {
            $this->showErro('-201');
        }
        if ((empty($mac) && empty($ifa)) ) {
            $this->showErro('-301');
        }
        if (!empty($mac)) {
            $condition['mac'] = $mac;
        }
        if (!empty($ifa)) {
            $condition['ifa'] = $ifa;
        }
        print_r($condition);
        $ordRecd =  Orders::where($condition)->orderBy('create_time', 'desc')->first();
        if (empty($ordRecd)) {
            $this->showErro('');
        }
        $ordRecd->status = 1;
        $status = $ordRecd->save();
        if ($status !== false) {
            $this->showSuccess();
        } else {
            $this->showErro('');
        }

    }
}