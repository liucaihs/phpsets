<?php
/**
 * Created by PhpStorm.
 * User: m
 * Date: 2017/7/28
 * Time: 9:00
 */
namespace App\Http\Controllers;
use Validator;
use App\Models\Channel;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ChannelController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $req)
    {
        $site = session('admuser.account');
        $data['adput_name'] = strip_tags($req->input('adput_name'));
        $data['puton_platform'] = intval($req->input('puton_platform'));
        $data['pay_type'] = intval($req->input('pay_type'));
        $ret = DB::select('select id FROM tb_media WHERE account = ?', [$site]);
        $data['media_id']=$ret[0]->id;
        $model = new Channel();
        $list = $model->getAllByPage($data);
        $page = $list->setPath('')->appends($req->all())->render();
        return view('channel.index', compact('list', 'page', 'data'));
    }

    public function pulldown(){
        $site = session('admuser.account');
        $ret = DB::select('select id FROM tb_media WHERE account = ?', [$site]);
        $rec = DB::select('select adput_name,id FROM tb_advertising WHERE media_id = ?', [$ret[0]->id]);
        echo json_encode($rec);
    }

}