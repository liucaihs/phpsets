<?php

namespace App\Http\Controllers;

use App\Models\Advertising;
use App\Models\Media;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Advputon;
use Validator;
use Illuminate\Validation\Rule;

class AdvputonController extends Controller
{
    protected $inputValide = [
        'adput_name.required' => '任务名称不能为空',
        'adput_name.unique' => '任务名称已存在',
        'adput_name.max' => '任务名称长度超出范围',
        'limited.integer' => '每日限额只能是整数',
        'reduction.integer' => '扣量比率只能是整数',
        'price.numeric' => '价格格式错误',
        'puton_url.url' => '投放链接包地址格式错误',
        'channel_url.url' => '回调链接格式错误',
    ];
    //
    public function __construct()
    {

    }

    public function index(Request $req)
    {
        $data['id'] = strip_tags($req->input('id'));
        $data['name'] = strip_tags($req->input('name'));
        $data['start_time'] =  strtotime(strip_tags($req->input('start_time')));
        $data['end_time'] = strtotime( strip_tags($req->input('end_time')));
        $data['media_id'] = strip_tags($req->input('media_id'));
        $data['media_name'] = strip_tags($req->input('media_name'));
        $model = new Advputon();
        $list = $model->getAllByPage($data);
        $page = $list->setPath('')->appends($req->all())->render();
        return view('advputon.index', compact('list', 'page', 'data'));
    }

    /*
     * 添加界面
     */
    public function addView(Request $req)
    {
        $clickSet = Setting::getSettingValue('adx_click');
        return view('advputon.add', ['adx_click' => $clickSet]);
    }

    /*
     * 保存编辑
     */
    public function store(Request $req)
    {
        $data = $req->all();
        $model = new Advputon();
        $data['create_time'] = time();
        $validator = Validator::make($data, [
            'adput_name' => 'required|unique:tb_advertising|max:50',
            'limited' => 'nullable|integer',
            'price' => 'numeric',
            'reduction' => 'nullable|integer',
            'puton_url' => 'url',
            'channel_url' => 'nullable|url',
        ], $this->inputValide);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $this->respJsonResult(0, $errors[0]);
        }
        $data['start_time'] = strtotime($data['start_time']);
        $data['end_time'] = strtotime($data['end_time']);
        if ($data['start_time'] >= $data['end_time']) {
            $this->respJsonResult(0, '投放结束时间必须大于开始时间！');
        }
        $data['price'] = $data['price'] * 100;
        $data['reduction'] = $data['reduction'] / 100;
        $adData = Advertising::where('id', $data['ad_id'])->first();
        $data['ad_name'] = $adData->ad_name;
        $data['into_price'] = $adData->into_price;
        $qdData = Media::where('id', $data['media_id'])->first();
        $data['media_name'] = $qdData->name;
        if (empty($data['use_api'])) {
            unset($data['channel_url']);
        } else {
            if(empty($data['channel_url'])) {
                $this->respJsonResult(0, '回调链接不能为空！');
            }
        }
        $data['limited'] = $data['limited'] + 0;
        $data['reduction'] = $data['reduction'] + 0;
        $data['adput_sn'] = $model->getAdPutonSn();

        $status = $model->addCommon($data);
        if ($status !== false) {
            $this->respJsonResult(1, '添加成功！');
        } else {
            $this->respJsonResult(0, '操作失败！');
        }
    }

    /*
     * 删除
     */
    public function del($id)
    {
        $status = Advputon::where('id', intval($id))->delete();
        if ($status !== false) {
            $this->respJsonResult(1, '删除成功！');
        } else {
            $this->respJsonResult(0, '删除失败！');
        }
    }

    /*
     * select
     */
    public function putselect()
    {
        $data = Advputon::all(['id' , 'adput_name'])->sortByDesc('create_time');
        echo json_encode($data);
    }
    /*
     * 编辑
     */
    public function update(Request $req, $id)
    {
        $model = new Advputon();
        if (!$req->isMethod("POST")) {
            $data = $model->getOneById(intval($id));
            $clickSet = Setting::getSettingValue('adx_click');
            return view('advputon.edit', ['row' => $data,'adx_click' => $clickSet]);
        } else {
            $data = $req->all();
            unset($data['_token']);

            $validator = Validator::make($data, [
                'adput_name' => [
                    'required',
                    Rule::unique('tb_advertising')->ignore($id),
                    'max:50'
                ],
                'limited' => 'nullable|integer',
                'price' => 'numeric',
                'reduction' => 'nullable|integer',
                'puton_url' => 'url',
                'channel_url' => 'nullable|url',
            ],  $this->inputValide);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $this->respJsonResult(0, $errors[0]);
            }
            $data['start_time'] = strtotime($data['start_time']);
            $data['end_time'] = strtotime($data['end_time']);
            if ($data['start_time'] >= $data['end_time']) {
                $this->respJsonResult(0, '投放结束时间必须大于开始时间！');
            }

            $data['price'] = $data['price'] * 100;
            $data['reduction'] = $data['reduction'] / 100;
            $adData = Advertising::where('id', $data['ad_id'])->first();
            $data['ad_name'] = $adData->ad_name;
            
            $qdData = Media::where('id', $data['media_id'])->first();
            $data['media_name'] = $qdData->name;
            if (empty($data['use_api'])) {
                unset($data['channel_url']);
            } else {
                if(empty($data['channel_url'])) {
                    $this->respJsonResult(0, '回调链接不能为空！');
                }
            }
            $data['limited'] = $data['limited'] + 0;
            $data['reduction'] = $data['reduction'] + 0;
            $status = $model->updateOne($id, $data);
            if ($status !== false) {
                $this->respJsonResult(1, '编辑成功！');
            } else {
                $this->respJsonResult(0, '编辑失败！');
            }
        }
    }

    /*
    * 暂停
    */
    public function stopAct(Request $req, $id)
    {
        $model = new Advputon();
        $data = $model->getOneById(intval($id));
        if (empty($data)) {
            $this->respJsonResult(0, '参数错误！');
        }
        $reset['status'] = $data['status'] == 1 ? 2 : 1;
        $reset['update_time'] = time();
        $status = $model->updateOne($id, $reset);
        if ($status !== false) {
            $this->respJsonResult(1, '操作成功！');
        } else {
            $this->respJsonResult(0, '操作失败！');
        }

    }

    /*
     * 复制界面
     */
    public function copyAct(Request $req, $id)
    {
        $model = new Advputon();
        $data = $model->getOneById(intval($id));
        return view('advputon.copy', ['row' => $data]);

    }
}
