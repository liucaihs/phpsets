<?php

namespace App\Http\Controllers;

use App\Models\ActIfa;
use App\Models\Activated;
use App\Models\Advputon;
use App\Models\ClickHis;
use App\Models\ClickLog;
use App\Models\Datetotal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;

class OperateController extends Controller
{
    //
    public function __construct()
    {
    }

    public function index(Request $req)
    {
        $curDate = strtotime(date("Y-m-d"));
        $data['puton_id'] = strip_tags($req->input('puton_id'));  //任务ID (广告投放)
        $condition['start_time'] = strtotime(strip_tags($req->input('start_time')));
        if (empty($condition['start_time'])) {
            $condition['start_time'] = $curDate;
        }
        $condition['end_time'] = strip_tags($req->input('end_time'));
        if (empty($condition['end_time'])) {
            $condition['end_time'] = strtotime($curDate . " 23:59:59");
        } else {
            $condition['end_time'] = strtotime($condition['end_time'] . " 23:59:59");
        }
        $data['end_time'] = $condition['end_time'];
        $data['start_time'] = $condition['start_time'];
        $data['media_id'] = strip_tags($req->input('media_id'));
        $data['ad_id'] = strip_tags($req->input('ad_id'));
        $data['ad_idsel'] = strip_tags($req->input('ad_idsel'));
        $adPuton = new Advputon();
        $model = new ClickLog();
        $condition['sn_in'] = $adPuton->getPutsnIn($data);

        $list = $model->getAllByPageTemp($condition);
        $total = $model->reckonTotal($condition);
        $page = $list->setPath('')->appends($req->all())->render();
        return view('operate.index', compact('list', 'page', 'data', 'total'));
    }

    public function totalCreate(Request $req)
    {
        set_time_limit(0);
        $inputs = $req->all();
        $curDate = date("Y-m-");
        echo $inputs['start'] . "---->" . $inputs['end'] . "<br/>";
        $putOns = Advputon::all()->toArray();

        $Datetotal = new Datetotal();
        for ($i = $inputs['start']; $i <= $inputs['end']; $i++) {
            $cur_date = $curDate . str_pad($i, 2, "0", STR_PAD_LEFT);
            echo $cur_date . "<br/>";
            foreach ($putOns as $puts) {
                $clicks = ClickLog::where('adput_sn', $puts['adput_sn'])->where('status', 1)->where(DB::raw("FROM_UNIXTIME(create_time, '%Y-%m-%d')"), $cur_date)->count();
                if (empty($clicks)) {
                    $cur_date . ":" . $puts['adput_sn'] . "  跳过<br/>";
                    continue;
                }

                $isExs = $Datetotal->where('adput_sn', $puts['adput_sn'])->where('total_date', $cur_date)->first();

                if (empty($isExs)) {

                    $status = $Datetotal->create(['adput_sn' => $puts['adput_sn'], 'total_date' => $cur_date, 'click_num' => $clicks]);
                    if ($status) {
                        echo $cur_date . ":" . $puts['adput_sn'] . "  更新完成<br/>";
                    } else {
                        echo $cur_date . ":" . $puts['adput_sn'] . "  更新失败！！！！！！！<br/>";
                    }
                } else {
                    $Datetotal->where('id', '=', intval($isExs->id))->update(['click_num' => $clicks]);
                }
//                sleep(5);
            }
        }

    }

    public function ifaOne(Request $req)
    {
        $ifa = strip_tags($req->input('ifa'));  //ifa
        $clickData = $activeData = [];
        if (!empty($ifa)) {
            $clickData = ClickLog::where('ifa', $ifa)->get();
            $activeData = Activated::where('ifa', $ifa)->get();
        }
        return view('operate.idfa', compact('clickData', 'activeData'));
    }

    public function recvIfaActivate(Request $req)
    {
        $ifa = strip_tags($req->input('ifa'));  //ifa
        $timestr = strip_tags($req->input('time'));  //ifa
        $model = new ActIfa();
        $dayNum = '';
        $currentQuery = $model->orderBy('id', 'desc');
        if (!empty($ifa)) {
            $currentQuery = $currentQuery->where('ifa', $ifa);
        }
        if (!empty($timestr)) {
            $currentQuery = $currentQuery->where(DB::raw("FROM_UNIXTIME(timestamp, '%Y-%m-%d')"), $timestr);
            $dayNum = ", {$timestr} 总记录条数：" . $model->where(DB::raw("FROM_UNIXTIME(timestamp, '%Y-%m-%d')"), $timestr)->count(DB::raw("distinct raw_data"));
        }
        $list = $currentQuery->paginate(15);
        $page = $list->setPath('')->appends($req->all())->render();
        $totalNum = $model->count(DB::raw("distinct raw_data"));
        return view('operate.recvifa', compact('list', 'page', 'totalNum', 'dayNum'));
    }

    public function moveHistoryClick(Request $req)
    {
        ignore_user_abort(); // run script in background
        set_time_limit(0); // run script forever
        $start =  strtotime(strip_tags($req->input('start')));

        $monthStart = time() - 60 * 60 * 24 * 10;
        if (!empty($start) && $start < $monthStart) {
            $monthStart = $start;
        }
        echo $monthStart;
        echo "|" . $monthStart;
        ClickLog::where('create_time', '<', $monthStart)->orderBy('id', 'asc')->chunk(100, function ($rows) {
            try{
                DB::beginTransaction();
                echo "--------";
                $chunkData = $rows->toArray();
                $delIds = array_column($chunkData, 'id');
                $inStatus = ClickHis::insert($chunkData);
                $delStatus = ClickLog::whereIn('id', $delIds)->delete();
                echo "chunkData count" . count($chunkData) . " , inStatus :" .var_export($inStatus, true) ." , delStatus :" .var_export($delStatus, true);
                echo "---------<br/>" .PHP_EOL;
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                echo "Message:".$e->getMessage()."<br>".$e->getCode()."<br>";
            }


        });
        exit;

    }
}
