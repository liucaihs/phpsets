<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
class Advertiser extends CommModel
{
    protected $table = "tb_advertisement";

    public $timestamps = false;

    protected $fillable = [
       
    ];

    public function getAllByPage($data)
    {
        $currentQuery = $this->orderBy('id',DB::raw("CONVERT(ad_name USING GBK)"), 'desc');
        $currentQuery->where('advertiser_id' ,'=', $data['advertiser_id']);
        if(isset($data['ad_name']) and ! empty($data['ad_name'])) {
            $currentQuery->where('ad_name' ,'=', $data['ad_name']);
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
