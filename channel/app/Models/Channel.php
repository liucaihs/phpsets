<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
class Channel extends CommModel
{
    protected $table = "tb_advertising";

    public $timestamps = false;

    protected $fillable = [
       
    ];

    public function getAllByPage($data)
    {
        $currentQuery = $this->orderBy('id',DB::raw("CONVERT(adput_name USING GBK)"), 'desc');
        $currentQuery->where('media_id' ,'=', $data['media_id']);
        if(isset($data['adput_name']) and ! empty($data['adput_name'])) {
            $currentQuery->where('adput_name' ,'=', $data['adput_name']);
        }
        if(isset($data['puton_platform']) and ! empty($data['puton_platform'])) {
            $currentQuery->where('puton_platform' ,'=', $data['puton_platform']);
        }
        if(isset($data['pay_type']) and ! empty($data['pay_type'])) {
            $currentQuery->where('pay_type' ,'=', $data['pay_type']);
        }
        $result = $currentQuery->paginate(self::PAGE_NUMS);
        return $result;
    }

}
