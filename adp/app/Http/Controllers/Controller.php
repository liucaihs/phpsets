<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function showErro($code)
    {
        $erroMsg = [
            '-201' => '未找到广告标示符',
            '-301' => '缺失设备参数',
            '-316' => '参数无法解析',
            '-401' => 'IP地址无效',
            '-501' => 'mac地址无效',
        ];

        if(empty($code) || !isset($erroMsg[$code])) {
            $code = '-316';
        }
        echo json_encode(['code' => $code , 'msg' => $erroMsg[$code]]);
        exit;
    }

    protected function showSuccess()
    {

        echo json_encode(['code' => '200' , 'msg' => 'success']);
        exit;
    }

    protected function checkMacAddr($mac)
    {
        $patternMac="/^[A-F0-9]{2}(-[A-F0-9]{2}){5}$/";  
        $isMac=false;
        $n = preg_match($patternMac, $mac); 
        if($n)
            $isMac=true;
        return $isMac;

    }
}
