<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    //
    //
    protected function responseJson($code = 1 , $msg  = 'success' )
    {
        header('Content-Type:application/json;charset=utf-8');
        echo json_encode(['code' => $code, 'msg' => $msg ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}
