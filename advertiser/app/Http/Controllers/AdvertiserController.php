<?php
/**
 * Created by PhpStorm.
 * User: m
 * Date: 2017/7/28
 * Time: 9:00
 */
namespace App\Http\Controllers;
use Validator;
use App\Models\Advertiser;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AdvertiserController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $req)
    {
        $site = session('admuser.account');
        $data['ad_name'] = strip_tags($req->input('ad_name'));
        $data['puton_platform'] = intval($req->input('puton_platform'));
        $data['pay_type'] = intval($req->input('pay_type'));
        $ret = DB::select('select id FROM tb_advertiser WHERE account = ?', [$site]);
        $data['advertiser_id']=$ret[0]->id;
        $model = new Advertiser();
        $list = $model->getAllByPage($data);
        $page = $list->setPath('')->appends($req->all())->render();
        return view('advertiser.index', compact('list', 'page', 'data'));
    }

    public function pulldown(){
        $site = session('admuser.account');
        $ret = DB::select('select id FROM tb_advertiser WHERE account = ?', [$site]);
        $rec = DB::select('select ad_name,id FROM tb_advertisement WHERE advertiser_id = ?', [$ret[0]->id]);
        echo json_encode($rec);
    }

}