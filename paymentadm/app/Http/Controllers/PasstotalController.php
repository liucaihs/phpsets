<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use App\Models\Sps;
use App\Models\Codetypes;
use App\Models\Payorders;
use Illuminate\Validation\Rule;

class PasstotalController extends Controller
{

    public function __construct()
    {

    }

    public function index(Request $req)
    {
        $data = Sps::orderBy('updated_at', 'desc')->orderBy('id', 'desc')->first(['id', 'name as ps_name'])->toArray();

        $data['name'] = strip_tags($req->input('spname', $data['ps_name']));
        $data['start'] = strip_tags($req->input('start_time', ""));
        $data['end'] = strip_tags($req->input('end_time', ""));

        $model = new Payorders();
        $curQuery = $model->select(array('appid', 'cpname'));
        $totalWh = "";
        if (!empty($data['name'])) {
            $totalWh = "spname = '{$data['name']}'";
            $curQuery->where('spname', $data['name']);
        }
        if (empty($data['start'])) {
            $data['start'] = date("Y-m-d 00:00:00");
        } else {
            $data['start'] .= " 00:00:00";
        }
        $totalWh .= " and created_at >= '{$data['start']}'";
        $curQuery->where('created_at', '>=', $data['start']);
        if (empty($data['end'])) {
            $data['end'] = date("Y-m-d 23:59:59");
        } else {
            $data['end'] .= " 23:59:59";
        }
        $totalWh .= " and created_at <= '{$data['end']}'";
        $curQuery->where('created_at', '<=', $data['end']);

        $yearMonth = str_replace('-', '', substr($data['end'], 0, 7));
        $startMonth = str_replace('-', '',substr($data['start'] , 0, 7));
        if ($yearMonth == $startMonth) {
            $totalWh .= " and `year_month` = '{$yearMonth}'";
            $curQuery->where('year_month', $yearMonth);
        }

        $total = ['pay_num' => 0, 'pay_mon' => 0, 'cancel_num' => 0, 'cancel_mon' => 0,];
        $curQuery->groupBy("appid");
        $curQuery->groupBy("cpname");
//        $curQuery->orderBy('codetypes.updated_at', 'desc')->orderBy('codetypes.id', 'desc');
        $list = $curQuery->paginate(config('app.PAGE_NUMS'));
        $page = $list->setPath('')->appends($req->all())->render();
        foreach ($list as $key => $value) {
            $list[$key]['pay_num'] = !empty($value['appid']) ? Payorders::where('appid', $value['appid'])->whereRaw($totalWh)->where('state', 0)->count() : 0;
            $total['pay_num'] += $list[$key]['pay_num'];
            $list[$key]['pay_mon'] = !empty($value['appid']) ? Payorders::where('appid', $value['appid'])->whereRaw($totalWh)->where('state', 0)->sum('price') : 0;
            $total['pay_mon'] += $list[$key]['pay_mon'];
            $list[$key]['cancel_num'] = !empty($value['appid']) ? Payorders::where('appid', $value['appid'])->whereRaw($totalWh)->where('state', 3)->count() : 0;
            $total['cancel_num'] += $list[$key]['cancel_num'];
            $list[$key]['cancel_mon'] = !empty($value['appid']) ? Payorders::where('appid', $value['appid'])->whereRaw($totalWh)->where('state', 3)->sum('price') : 0;
            $total['cancel_mon'] += $list[$key]['cancel_mon'];
        }
        return view('passtotal.index', compact('list', 'page', 'data', 'total'));
    }

    public function indexAll(Request $req)
    {
        $splist = Sps::orderBy('updated_at', 'desc')->orderBy('id', 'desc')->select(['id', 'name as ps_name'])->paginate(1000);//config('app.PAGE_NUMS'));
        $page = $splist->setPath('')->appends($req->all())->render();

        $data['start'] = strip_tags($req->input('start_time', ""));
        $data['end'] = strip_tags($req->input('end_time', ""));

        if (empty($data['start'])) {
            $data['start'] = date("Y-m-d 00:00:00");
        } else {
            $data['start'] .= " 00:00:00";
        }

        if (empty($data['end'])) {
            $data['end'] = date("Y-m-d 23:59:59");
        } else {
            $data['end'] .= " 23:59:59";
        }
        $yearMonth = str_replace('-', '', substr($data['end'], 0, 7));
        $startMonth = str_replace('-', '',substr($data['start'] , 0, 7));

        foreach ($splist as $spid => $value) {

            $data['name'] = $value->ps_name;
            $model = new Payorders();
            $curQuery = $model->select(array('appid', 'cpname'));
            $totalWh = "";

            $totalWh = "spname = '{$data['name']}'";
            $curQuery->where('spname', $data['name']);
            $totalWh .= " and created_at >= '{$data['start']}'";
            $curQuery->where('created_at', '>=', $data['start']);

            $totalWh .= " and created_at <= '{$data['end']}'";
            $curQuery->where('created_at', '<=', $data['end']);

            if ($yearMonth == $startMonth) {
                $totalWh .= " and `year_month` = '{$yearMonth}'";
                $curQuery->where('year_month', $yearMonth);
            }
            $alltotal = ['pay_num' => 0, 'pay_mon' => 0, 'cancel_num' => 0, 'cancel_mon' => 0,];
            $total = ['pay_num' => 0, 'pay_mon' => 0, 'cancel_num' => 0, 'cancel_mon' => 0,];
            $curQuery->groupBy("appid");
            $curQuery->groupBy("cpname");
//        $curQuery->orderBy('codetypes.updated_at', 'desc')->orderBy('codetypes.id', 'desc');
            $list = $curQuery->paginate(config('app.PAGE_NUMS'));
            foreach ($list as $key => $value) {
                $list[$key]['pay_num'] = !empty($value['appid']) ? Payorders::where('appid', $value['appid'])->whereRaw($totalWh)->where('state', 0)->count() : 0;
                $total['pay_num'] += $list[$key]['pay_num'];
                $alltotal['pay_num'] += $list[$key]['pay_num'];
                $list[$key]['pay_mon'] = !empty($value['appid']) ? Payorders::where('appid', $value['appid'])->whereRaw($totalWh)->where('state', 0)->sum('price') : 0;
                $total['pay_mon'] += $list[$key]['pay_mon'];
                $alltotal['pay_mon'] += $list[$key]['pay_mon'];
                $list[$key]['cancel_num'] = !empty($value['appid']) ? Payorders::where('appid', $value['appid'])->whereRaw($totalWh)->where('state', 3)->count() : 0;
                $total['cancel_num'] += $list[$key]['cancel_num'];
                $alltotal['cancel_num'] += $list[$key]['cancel_num'];
                $list[$key]['cancel_mon'] = !empty($value['appid']) ? Payorders::where('appid', $value['appid'])->whereRaw($totalWh)->where('state', 3)->sum('price') : 0;
                $total['cancel_mon'] += $list[$key]['cancel_mon'];
                $alltotal['cancel_mon'] += $list[$key]['cancel_mon'];
            }
            $lists[$spid]['ps_name'] = $data['name'];
            $lists[$spid]['data'] = $list;
            $lists[$spid]['total'] = $total;
        }

        return view('passtotal.indexall', compact('lists', 'page', 'data','alltotal'));
    }
}