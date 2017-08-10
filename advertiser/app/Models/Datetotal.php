<?php

namespace App\Models;


class Datetotal extends CommModel
{
    //
    protected $table = "tb_date_total";

    protected $fillable = [
        'adput_sn', 'total_date', 'click_num', 'activate_num', 'start_cid', 'notclasp',
    ];
    public $timestamps = false;

    /**
     * 取得所有的
     * parm $data array
     * @return array
     */
    public function getAllByPage($data)
    {
        $currentQuery = $this->leftJoin('tb_platform', 'tb_media.belongs', '=', 'tb_platform.id')
            ->select(array('tb_media.*','tb_platform.name as platform'))->orderBy('id', 'desc');
        if(isset($data['name']) and ! empty($data['name'])) {
            $currentQuery->where('tb_media.name', '' , $data['name']);
        }
        if(isset($data['id']) and ! empty($data['id'])) {
            $currentQuery->where('tb_media.id', $data['id']);
        }
        if(isset($data['belong']) and ! empty($data['belong'])) {
            $currentQuery->where('tb_media.belongs', $data['belong']);
        }
        if(isset($data['channel_type']) and ! empty($data['channel_type'])) {
            $currentQuery->where('tb_media.channel_type', $data['channel_type']);
        }
//        if(isset($data['starttime']) and ! empty($data['starttime'])) {
//            $currentQuery->where('create_time', '>=', strtotime($data['starttime']));
//        }


        $result = $currentQuery->paginate(self::PAGE_NUMS);
        return $result;
    }

}

