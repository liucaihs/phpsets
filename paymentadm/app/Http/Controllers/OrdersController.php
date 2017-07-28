<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payorders;

class OrdersController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $req)
    {
        $data['name'] = strip_tags($req->input('cpname', ''));
        $data['appid'] = strip_tags($req->input('appid', ''));
        $data['start'] = strip_tags($req->input('start_time', ""));
        $data['end'] = strip_tags($req->input('end_time', ""));

        $model = new Payorders();
        $curQuery = $model->select();

        if (!empty($data['name'])) {
            $curQuery->where('cpname', $data['name']);
        }
        if (!empty($data['appid'])) {
            $curQuery->where('appid', $data['appid']);
        }
        if (empty($data['start'])) {
            $data['start'] = date("Y-m-d 00:00:00");
        } else {
            $data['start'] .=  " 00:00:00";
        }
        $curQuery->where('created_at', '>=', $data['start']);
        if (empty($data['end'])) {
            $data['end'] = date("Y-m-d 23:59:59");
        } else {
            $data['end'] .=  " 23:59:59";
        }
        $curQuery->where('created_at', '<=', $data['end']);

        $yearMonth = str_replace('-', '',substr($data['end'] , 0, 7));
        $startMonth = str_replace('-', '',substr($data['start'] , 0, 7));
        if ($yearMonth == $startMonth) {
            $curQuery->where('year_month', $yearMonth);
        }
        $curQuery->orderBy('id', 'desc');
        $list = $curQuery->paginate(config('app.PAGE_NUMS'));
        $page = $list->setPath('')->appends($req->all())->render();

        return view('orders.index', compact('list', 'page', 'data'));
    }
}
