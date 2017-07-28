<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use App\Models\Appids;
use App\Models\Codetypes;
use App\Models\Payorders;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ChantotalController extends Controller
{

    public function __construct()
    {

    }

    public function index(Request $req)
    {

        $data['start'] = strip_tags($req->input('start_time', ""));
        $data['end'] = strip_tags($req->input('end_time', ""));

        $model = new Payorders();
        $curQuery = $model->select(array('appid', 'cpname',  DB::raw("count(id) AS nums"), DB::raw("sum(price) AS money"),
            DB::raw("SUM(IF(notify_state = 1, 1, 0)) AS tb_num"), DB::raw("SUM(IF(notify_state = 1, price, 0)) AS tb_money"),));
        $totalWh = "";

        if (empty($data['start'])) {
            $data['start'] = date("Y-m-d 00:00:00");
        } else {
            $data['start'] .=  " 00:00:00";
        }
        $totalWh .= " and created_at >= '{$data['start']}'";
        $curQuery->where('created_at', '>=', $data['start']);
        if (empty($data['end'])) {
            $data['end'] = date("Y-m-d 23:59:59");
        } else {
            $data['end'] .=  " 23:59:59";
        }
        $totalWh .= " and created_at <= '{$data['end']}'";
        $curQuery->where('created_at', '<=', $data['end']);

        $yearMonth = str_replace('-', '',substr($data['end'] , 0, 7));
        $startMonth = str_replace('-', '',substr($data['start'] , 0, 7));
        if ($yearMonth == $startMonth) {
            $totalWh .= " and `year_month` = '{$yearMonth}'";
            $curQuery->where('year_month', $yearMonth);
        }

        $curQuery->groupBy("appid");
        $curQuery->groupBy("cpname");
        $curQuery->orderBy('cpname', 'asc')->orderBy('appid', 'asc');
        $list = $curQuery->paginate(config('app.PAGE_NUMS'));
        $page = $list->setPath('')->appends($req->all())->render();
        foreach ($list as $key => $value) {
            $appModel = Appids::where('appid' , $value->appid)->first();
            $list[$key]['notify_rate'] = isset($appModel->notify_rate) ? $appModel->notify_rate : "";
        }
        return view('chantotal.index', compact('list', 'page', 'data'));
    }


}