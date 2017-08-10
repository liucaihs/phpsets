<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    //protected $connection = 'bp';//切换数据库
    protected $table = "tb_advertiser";

    public $timestamps = false;

    public static function getAdminInfo($user_name)
    {
        
        if (empty($user_name)) {
            return [];
        }
        $admData =  Admin::where('account', $user_name)->first();
        return $admData;
    }
}
