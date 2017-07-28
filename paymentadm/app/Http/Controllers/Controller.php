<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function respJsonResult($code , $msg , $data = '')
    {
        $result['code'] = $code;
        $result['msg'] = $msg;
        if (is_array($data)) {
            $result['data'] = $data;
         }

        echo json_encode( $result );
        exit;
    }

    protected function validatorFails($validator)
    {
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $this->respJsonResult(0, $errors[0]);
        }
        return ;
    }

}
