<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    //
    protected $table = "tb_admin";

    public $timestamps = false;

    public static function getAdminInfo($user_name)
    {
        if (empty($user_name)) {
            return [];
        }
        $admData =  Admin::where('admin_account', $user_name)->first();
        return $admData;
    }
}
