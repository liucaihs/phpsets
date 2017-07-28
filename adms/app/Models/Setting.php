<?php

namespace App\Models;


class Setting extends CommModel
{
    //
    //
    protected $table = "tb_setting";

    protected $fillable = [
        'name', 'belongs', 'channel_type', 'contacts', 'status', 'phone', 'create_time','update_time'
    ];
    public $timestamps = false;

    public static function getSettingValue($key)
    {
        $result = "";
        if (!empty($key)) {
            $reset = self::where('key' , $key)->first();
            $result = isset($reset->value) ? $reset->value : "";
        }
        return $result;
    }
}
