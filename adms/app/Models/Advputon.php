<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
class Advputon extends CommModel
{
    protected $table = "tb_advertising";
    protected $fillable = [
        'adput_sn', 'adput_name', 'ad_id', 'ad_name', 'media_id', 'media_name','pay_type' , 'remark'
        , 'price', 'puton_url', 'channel_url', 'start_time', 'end_time','limited', 'status', 'create_time', 'update_time' , 'use_api','reduction'
    ];
    public $timestamps = false;
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

    public function getAllByPage($data)
    {
        $currentQuery = $this->orderBy('create_time', 'desc');
        if (isset($data['name']) and !empty($data['name'])) {
            $currentQuery->where('adput_name' ,'like', "%" .$data['name'] ."%"  );//'like', "%" . $data['name'] . "%");
        }
        if (isset($data['id']) and !empty($data['id'])) {
            $currentQuery->where('id' , $data['id']  );
        }
        if (isset($data['media_name']) and !empty($data['media_name'])) {
            $currentQuery->where('media_name' ,'like', "%" .$data['media_name'] ."%"  );
        }
        if (isset($data['media_id']) and !empty($data['media_id'])) {
            $currentQuery->where('media_id' , $data['media_id']  );
        }
        if ( !empty($data['start_time']) and !empty($data['end_time'])) {
            $currentQuery->whereRaw("(start_time <= {$data['start_time']} and end_time >= {$data['start_time']}) or (start_time <= {$data['end_time']} and end_time >= {$data['end_time']})  or (start_time >= {$data['start_time']} and end_time <= {$data['end_time']})");
        } elseif (!empty($data['start_time']) and  empty($data['end_time'])) {
            $currentQuery->whereRaw("(start_time <= {$data['start_time']} and end_time >= {$data['start_time']})");
        } elseif (empty($data['start_time']) and  !empty($data['end_time'])) {
            $currentQuery->whereRaw("(start_time <= {$data['end_time']} and end_time >= {$data['end_time']})");
        }
        $result = $currentQuery->paginate(self::PAGE_NUMS);

        $this->handleStatus($result);
        return $result;
    }

    public function handleStatus(&$result)
    {
        $curtime = time();
        foreach( $result as $key => $row ) {
            if ($row->status == 1) {
                if ( $curtime < $row->start_time) {
                    $row->status = "待投放";
                } elseif ($curtime <= $row->end_time && $curtime >= $row->start_time) {
                    $is_over = $this->judgeOver($row);
                    if ($is_over) {
                        $row->status = "投放中";
                    } else{
                        $row->status = "超量";
                    }
                } elseif ($curtime > $row->end_time ) {
                    $row->status = "结束";
                }
            } elseif ($row->status ==2) {
                $row->status = "暂停";
            }
        }
    }

    //true 不超量
    public function judgeOver($row)
    {
        $res = true;
        if(empty($row->limited) || $row->limited < 0 ) {
            return true;
        }
        $active_nums = Activated::where('adput_sn', $row->adput_sn)->where(DB::raw("FROM_UNIXTIME(create_time, '%Y-%m-%d')") ,date("Y-m-d"))->count();
        return $active_nums <= $row->limited;
    }

    public function getAdPutonSn()
    {
        $put_sn = uniqid('po');
        $adPuton =  Advputon::where('adput_sn', $put_sn)->first();
        if (!empty($adPuton)) {
            return $this->getAdvPuton();
        } else {
            return $put_sn;
        }
    }

    /*
     * 数据统计 adput_sn in
     */
    public function getPutsnIn($data)
    {
        $snArr = [];
        $currentQuery = $this->select('adput_sn')->orderBy('create_time', 'desc');

        if (isset($data['puton_id']) and !empty($data['puton_id'])) {
            $currentQuery->where('id' , $data['puton_id']  );
        }

        if (isset($data['media_id']) and !empty($data['media_id'])) {
            $currentQuery->where('media_id' , $data['media_id']  );
        }
        if (isset($data['ad_id']) and !empty($data['ad_id'])) {
            $currentQuery->where('ad_id' , $data['ad_id']  );
        }
        if (isset($data['ad_idsel']) and !empty($data['ad_idsel'])) {
            $currentQuery->where('ad_id' , $data['ad_idsel']  );
        }
        $result = $currentQuery->get();

        foreach ($result as $row) {
            array_push($snArr , $row->adput_sn);
        }

        return $snArr;
    }
}
