<?php

namespace App\Models;


class Advertising extends CommModel
{
    //
    protected $table = "tb_advertisement";

    protected $fillable = [
        'ad_name', 'advertiser_id', 'pay_type', 'into_price', 'puton_platform', 'owner_apiurl', 'puton_url', 'start_time', 'end_time','remark','urlencode','create_time'
    ];
    public $timestamps = false;


    public function getAdverTiser($data)
    {
        $currentQuery = $this->orderBy('id', 'desc');
        if(isset($data['adname']) and ! empty($data['adname'])) {
            $currentQuery->where('ad_name' ,'like', "%" .$data['adname'] ."%"  );
        }
        if(isset($data['client_id']) and ! empty($data['client_id'])) {
            $currentQuery->where('id', $data['client_id']);
        }

        $result = $currentQuery->paginate(self::PAGE_NUMS);
        return $result;
    }

}
