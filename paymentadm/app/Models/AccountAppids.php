<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountAppids extends Model
{
    //
    protected $fillable = array('appid' );
    public static function getAccountIds($id)
    {
        $result = [];
        if (!empty($id)) {
            $data = self::where('account_id' , intval($id))->select(['appid'])->get()->toArray();
            array_walk($data , function($item, $key) use (&$result) {
                array_push($result , $item['appid']);
            });
        }
        return $result;
    }
}
