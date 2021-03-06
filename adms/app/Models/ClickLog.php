<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class ClickLog extends CommModel
{
    //
    protected $table = "tb_click_log";
    protected $fillable = [
    ];
    public $timestamps = false;

    public function getAllByPageTemp($data , $is_page = 1)
    {
        $this->table = "tb_date_total";
        $currentQuery = $this->select('adput_sn', "click_num as click_nums" , "total_date as days");

        if (isset($data['sn_in']) and !empty($data['sn_in'])) {
            $currentQuery->whereIn('adput_sn' , $data['sn_in']  );
        }
        if (isset($data['start_time']) and  !empty($data['start_time'])) { //
            $currentQuery->where('total_date', '>=',  date("Y-m-d" ,$data['start_time']) );
        }
        if (isset($data['end_time']) and  !empty($data['end_time'])) {
            $currentQuery->where('total_date', '<=', date("Y-m-d" , $data['end_time']));
        }

        $currentQuery->orderBy('total_date', 'desc');
        $currentQuery->orderBy('adput_sn', 'desc');
        if ($is_page) {
            $result = $currentQuery->paginate(self::PAGE_NUMS);
        } else {
            $result = $currentQuery->get();
        }
        $this->apendData($result);

        return $result;
    }

    public function getAllByPage($data , $is_page = 1)
    {

        $currentQuery = $this->select('adput_sn',DB::raw("count(*) as click_nums") ,DB::raw("FROM_UNIXTIME(create_time, '%Y-%m-%d') as days"));
        $currentQuery->where('status' , 1 );
        if (isset($data['sn_in']) and !empty($data['sn_in'])) {
            $currentQuery->whereIn('adput_sn' , $data['sn_in']  );
        }
        if (isset($data['start_time']) and  !empty($data['start_time'])) { //
            $currentQuery->where('create_time', '>=',  $data['start_time']);
        }
        if (isset($data['end_time']) and  !empty($data['end_time'])) {
            $currentQuery->where('create_time', '<=',  $data['end_time']);
        }
        $currentQuery->groupBy("adput_sn");
        $currentQuery->groupBy(DB::raw("FROM_UNIXTIME(create_time, '%Y-%m-%d')"));
        $currentQuery->orderBy(DB::raw("FROM_UNIXTIME(create_time, '%Y-%m-%d')"), 'desc');
        $currentQuery->orderBy('adput_sn', 'desc');
        if ($is_page) {
            $result = $currentQuery->paginate(self::PAGE_NUMS);
        } else {
            $result = $currentQuery->get();
        }
        $this->apendData($result);

        return $result;
    }

    protected function apendData(&$data)
    {

        foreach ($data as $row) {
            $row->days = str_replace(' 00:00:00', '' , $row->days);
            $ad_puton = Advputon::where('adput_sn', $row->adput_sn)->first();
            $active_nums = Activated::where('adput_sn', $row->adput_sn)->where(DB::raw("FROM_UNIXTIME(create_time, '%Y-%m-%d')") ,$row->days)->count(DB::raw("distinct raw_data"));
            $notclasp_nums = Activated::where('adput_sn', $row->adput_sn)->where('clasp', 0)->where(DB::raw("FROM_UNIXTIME(create_time, '%Y-%m-%d')") ,$row->days)->count(DB::raw("distinct raw_data"));
            $adData = Advertising::where('id', $ad_puton->ad_id)->first();

            $costprice  = 0 ;
            switch($ad_puton->pay_type){  //1 cpm (曝光), 2 cpc(点击) ，3：cpa （激活）
                case 2 : 
                    $costprice = $row->click_nums * $ad_puton->price;
                    break;
                case 3 :
                    $costprice = $notclasp_nums * $ad_puton->price;
                    break;
            }

            $row->setAttribute('show_nums', 0);
            $row->setAttribute('ad_id', $ad_puton->ad_id);
            $row->setAttribute('ad_name', $ad_puton->ad_name);
            $row->setAttribute('media_id', $ad_puton->media_id);
            $row->setAttribute('media_name', $ad_puton->media_name);
            $row->setAttribute('adput_name', $ad_puton->adput_name);
            $row->setAttribute('price', $ad_puton->price);
            $row->setAttribute('into_price', $adData->into_price);
            $row->setAttribute('active_nums', $active_nums);
            $row->setAttribute('notclasp_nums', $notclasp_nums);
            $row->setAttribute('costprice', $costprice);
        }
    }

    public function reckonTotal($data)
    {
        $reset =  $this->getAllByPageTemp($data , 0);// $this->getAllByPage($data , 0);

        $totalData = ['show_nums' => 0 , 'click_nums' => 0 , 'active_nums' => 0 , 'costprice' => 0 , 'active_percent' => '0%'];
        foreach ($reset as $row) {
            $totalData['click_nums'] += $row->click_nums;
            $totalData['active_nums'] += $row->active_nums;
            $totalData['costprice'] += $row->costprice;
        }
        if ($totalData['click_nums'] > 0) {
            $totalData['active_percent'] = round($totalData['active_nums']/$totalData['click_nums'] * 100, 2) . '%';
        }
        return $totalData;
    }
}
