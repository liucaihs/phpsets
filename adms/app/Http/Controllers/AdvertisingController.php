<?php
/**
 * Created by PhpStorm.
 * User: m
 * Date: 2017/5/27
 * Time: 14:12
 */
namespace App\Http\Controllers;
use Validator;
use App\Common\Regex;
use App\Models\Advertising;
use App\Models\Advertiser;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class AdvertisingController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $req)
    {
        $data['adname'] = strip_tags($req->input('adname'));
        $data['client_id'] = intval($req->input('client_id'));

        $model = new Advertising();
        $list = $model->getAdverTiser($data);
        $page = $list->setPath('')->appends($req->all())->render();
        return view('advertising.index', compact('list', 'page', 'data'));
    }

    public function pulldown(Request $req)
    {
        $data = Advertiser::all()->sortBy("id")->toArray();
        echo json_encode($data);
    }


    /*
     *广告下拉选择框
     */
    public function advselect()
    {
        $data = Advertising::all(['id' , 'ad_name as name'])->sortByDesc('create_time');
        echo json_encode($data);
    }


    public function add(Request $req)
    {
        return view('advertising.add', []);
    }

    public function store(Request $req)
    {
        $data = $req->all();
        $model = new Advertising();
        $validator = Validator::make($data , [
            'ad_name' => 'required|unique:tb_advertisement|max:255',
            'puton_url' => 'url',
            'owner_apiurl' => 'url',
        ],[
            'ad_name.required' => 0,
            'ad_name.unique' => 1,
            'ad_name.max' => 2,
            'puton_url.url' => 3,
            'owner_apiurl.url' => 4,
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $this->respJsonResult(0, $errors[0]);
        }
        if (!empty($data['start_time'])) {
            $data['start_time'] = strtotime($data['start_time']);
        }
        if (!empty($data['end_time'])) {
            $data['end_time'] = strtotime($data['end_time']);
        }
        $data['into_price']=$data['into_price']*100;
        $status = $model->addCommon($data);
        if ($status !== false) {
            $this->respJsonResult(1, 'ok！');
        } else {
            $this->respJsonResult(0, 'error！');
        }
    }

    public function delete($id){
        $status =  Advertising::where('id',intval($id))->delete();
        if ($status !== false) {
            $this->respJsonResult(1, 'delete！');
        } else {
            $this->respJsonResult(0, 'no delete！');
        }
    }

    public function update(Request $req)
    {
        $data = $req->all();
        $id =$data['id'];
        $model = new Advertising();
        $validator = Validator::make($data , [
            'ad_name' =>  ['required',
            Rule::unique('tb_advertisement')->ignore($id),
            'max:255',
            ],
            'puton_url' => 'url',
            'owner_apiurl' => 'url',
        ],['ad_name.required' => 0,
            'ad_name.unique' => 1,
            'ad_name.max' => 2,
            'puton_url.url' => 3,
            'owner_apiurl.url' => 4,
        ]);
        unset($data['_token']);
        unset($data['inlineRadi']);
        unset($data['urlencodei']);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $this->respJsonResult(0, $errors[0]);
        }
        if (!empty($data['start_time'])) {
            $data['start_time'] = strtotime($data['start_time']);
        }
        if (!empty($data['end_time'])) {
            $data['end_time'] = strtotime($data['end_time']);
        }
        $data['into_price']=$data['into_price']*100;
        $status = $model->updateOne($id ,$data);
        if ($status !== false) {
            $this->respJsonResult(1, 'ok！');
        } else {
            $this->respJsonResult(0, 'error！');
        }
    }
}