<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use App\Models\Opts;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    //
    public function __construct()
    {

    }

    public function index(Request $req)
    {

        $data['name'] = strip_tags($req->input('name', ''));
        $model = new Opts();
        $list = $model->orderBy('updated_at', 'desc')->orderBy('id', 'desc')->where('key', 'like', '%' . $data['name'] . '%')->paginate(config('app.PAGE_NUMS'));
        $page = $list->setPath('')->appends($req->all())->render();
        return view('setting.index', compact('list', 'page', 'data'));
    }

    public function saveInsert(Request $req)
    {
        $id = intval($req->input('id', ''));
        $inputs = array_only($req->all(), ['key', 'value']);
        if (empty(json_decode($inputs['value']))) {
            $this->respJsonResult(0, '配置值格式错误');
        }

        if ($id > 0) {
            $validator = Validator::make($inputs, [
                'key' => [
                    'required',
                    Rule::unique('opts')->ignore($id),
                    'max:128'
                ]
            ], [
                'key.required' => '配置键不能为空',
                'key.unique' => '配置键已存在',
                'key.max' => '配置键长度超出范围',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $this->respJsonResult(0, $errors[0]);
            }

            $status = Opts::where('id', $id)->update($inputs);;
        } else {
            $validator = Validator::make($inputs, [
                'key' => 'required|unique:opts|max:128',
            ], [
                'key.required' => '配置键不能为空',
                'key.unique' => '配置键已存在',
                'key.max' => '配置键长度超出范围',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $this->respJsonResult(0, $errors[0]);
            }

            $model = new Opts();
            $status = $model->create($inputs);
        }

        if ($status !== false) {
            $this->respJsonResult(1, '操作成功！');
        } else {
            $this->respJsonResult(0, '操作失败！');
        }
    }

    /*
  * 删除
  */
    public function del($id)
    {
        $status = Opts::where('id', intval($id))->delete();
        if ($status !== false) {
            $this->respJsonResult(1, '删除成功！');
        } else {
            $this->respJsonResult(0, '删除失败！');
        }
    }
}