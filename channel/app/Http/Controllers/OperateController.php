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
        $site = session('admuser.account');
        $ret = DB::select('select id FROM tb_media WHERE account = ?', [$site]);
        $curDate = strtotime(date("Y-m-d"));
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
        $data['media_id'] = $ret[0]->id;
        $data['ad_idsel'] = strip_tags($req->input('ad_idsel'));
        $adPuton = new Advputon();
        $model = new ClickLog();
        $condition['sn_in'] = $adPuton->getPutsnIn($data);

        $list = $model->getAllByPageTemp($condition);
        $total = $model->reckonTotal($condition);
        $page = $list->setPath('')->appends($req->all())->render();
        return view('operate.index', compact('list', 'page', 'data', 'total'));
    }
}
