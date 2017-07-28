<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advputon extends Model
{
    protected $table = "tb_advertisement_puton";

    /*
     * 通过广告投放媒体表示获取广告投放记录
     * parm string $put_sn
     * return array
     */
    public static function getAdvPuton($put_sn)
    {
        if (empty($put_sn)) {
            return [];
        }
        $data = [];
        $adPuton =  Advputon::where('adput_sn', $put_sn)->first();
        if (!empty($adPuton)) {
            $data = $adPuton->toArray();
        }
        return $data;
    }
}
