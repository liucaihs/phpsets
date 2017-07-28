<?php
namespace App\Common;


class Regex
{
    //电话格式1xxxxxxxxxx或xxx-xxxxxxxx
    public static function IsPhone($phoneStr)
    {
        $isPhone=false;
        if (strlen($phoneStr) == "11"||strlen($phoneStr)=="12") {
            $n = preg_match_all("/1\d{10}|\d{3}-\d{8}/", $phoneStr, $array);
            if($n)
                $isPhone=true;
        } else {
            $isPhone=false;
        }
        return $isPhone;
    }

}