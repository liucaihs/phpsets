<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use App\Models\Appids;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ChannelController extends Controller
{
    //
    protected $_valiMsg = [
        'appid.required' => 'appid不能为空',
        'appid.unique' => 'appid已存在',
        'appid.max' => 'appid超出范围',
        'notify_rate.integer' => '同步率只能是小于1的整数',
        'notify_rate_m2.integer' => '次月同步率只能是小于1的整数',
        'notify_rate.max' => '同步率只能是小于1的整数',
        'notify_rate_m2.max' => '次月同步率只能是小于1的整数',
    ];

    public function __construct()
    {

    }

    public function index(Request $req)
    {

        $data['name'] = strip_tags($req->input('name', ''));
        $data['appid'] = strip_tags($req->input('appid', ''));
        $model = new Appids();
        $list = $model->orderBy('cpname', 'asc')->orderBy('updated_at', 'desc')->orderBy('id', 'desc')
            ->where('cpname', 'like', '%' . $data['name'] . '%')
            ->where('appid', 'like', '%' . $data['appid'] . '%')
            ->paginate(config('app.PAGE_NUMS'));
        $page = $list->setPath('')->appends($req->all())->render();
        return view('channel.index', compact('list', 'page', 'data'));
    }

    public function saveInsert(Request $req)
    {
        $id = intval($req->input('id', ''));
        $model = new Appids();
        $inputs = array_only($req->all(), $model->getFillable());
        $appidArrs = explode(',', $inputs['appid']);
        $appidArrs = array_unique($appidArrs);

        DB::beginTransaction();
        if ($id > 0) {
            $inputs['appid'] = $appidArrs[0];
            $validator = Validator::make($inputs, [
                'appid' => [
                    'required',
                    Rule::unique('appids')->ignore($id),
                    'max:64'
                ],
                'notify_url' => 'nullable|url',
                'notify_rate' => 'nullable|numeric|max:1|min:0',
                'notify_rate_m2' => 'nullable|numeric|max:1|min:0',
            ], $this->_valiMsg);
            $this->validatorFails($validator);

            $status = Appids::where('id', $id)->update($inputs);
            if ($status !== false) {
                unset($appidArrs[0]);
                $status = $this->createMuchRec($model, $inputs, $appidArrs);
            }
        } else {
            $status = $this->createMuchRec($model, $inputs, $appidArrs);
        }

        if ($status !== false) {
            DB::commit();
            $this->respJsonResult(1, '操作成功！');
        } else {
            DB::rollBack();
            $this->respJsonResult(0, '操作失败！');
        }
    }

    public function saveRate(Request $req)
    {
        $model = new Appids();
        $inputs = array_only($req->all(), $model->getFillable());
        $inputs['notify_rate'] = $inputs['notify_rate']/100;
        $validator = Validator::make($inputs, [
            'notify_rate' => 'nullable|numeric|max:1|min:0',
            'notify_rate_m2' => 'nullable|numeric|max:1|min:0',
        ], $this->_valiMsg);
        $this->validatorFails($validator);
        $appid = $inputs['appid'];
        unset($inputs['appid']);
        $status = Appids::where('appid', $appid)->update($inputs);

        if ($status !== false) {
            $this->respJsonResult(1, '操作成功！');
        } else {
            $this->respJsonResult(0, '操作失败！');
        }
    }

    private function createOneRec($model, $inputs)
    {
        $validator = Validator::make($inputs, [
            'appid' => 'required|unique:appids|max:64',
            'notify_url' => 'nullable|url',
            'notify_rate' => 'nullable|numeric|max:2|min:0',
            'notify_rate_m2' => 'nullable|numeric|max:2|min:0',
        ], $this->_valiMsg);
        $this->validatorFails($validator);

        $status = $model->create($inputs);
        return $status;
    }

    private function createMuchRec($model, $inputs, $appidArrs)
    {
        foreach ($appidArrs as $key => $val) {
            $inputs['appid'] = $val;
            $status = $this->createOneRec($model, $inputs);
            if ($status === false) {
                return false;
            }
        }
        return true;
    }

    /*
  * 删除
  */
    public function del($id)
    {
        $status = Appids::where('id', intval($id))->delete();
        if ($status !== false) {
            $this->respJsonResult(1, '删除成功！');
        } else {
            $this->respJsonResult(0, '删除失败！');
        }
    }


    /*
       *渠道下拉选择框
       */
    public function chanselect()
    {
        $data = Appids::orderBy('cpname', 'asc')->groupBy('cpname')->get(['cpname as name']);
        echo json_encode($data);
    }

    /*
      *appid下拉选择框
      */
    public function appidselect(Request $req, $name = "")
    {
        $model = Appids::orderBy('appid', 'desc');
        $name = strip_tags($name);
        if (!empty($name)) {
            $model->where('cpname', $name);
        }
        $data = $model->groupBy('appid')->get(['appid as name']);
        echo json_encode($data);
    }

}