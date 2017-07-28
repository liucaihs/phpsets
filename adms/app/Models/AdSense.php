<?php

namespace App\Models;


class AdSense extends CommModel
{
    //
    protected $table = "";

    protected $fillable = [
        'name', 'industry', 'address', 'contacts', 'create_time', 'phone', 'sales', 'remark'
    ];
    public $timestamps = false;


    public function getAdverTiser($data)
    {
        $currentQuery = $this->orderBy('id', 'desc');
        if(isset($data['advertiser']) and ! empty($data['advertiser'])) {
            $currentQuery->where('name' ,'like', "%" .$data['advertiser'] ."%"  );
        }
        if(isset($data['client_ID']) and ! empty($data['client_ID'])) {
            $currentQuery->where('id', $data['client_ID']);
        }

        $result = $currentQuery->paginate(self::PAGE_NUMS);
        return $result;
    }

}