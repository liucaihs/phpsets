<?php

namespace App\Http\Controllers;

use Validator;
use App\Common\Regex;
use App\Models\Cmdb;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class CMDBController extends Controller
{
    //
    public function __construct()
    {

    }

    public function index(Request $req)
    {
        $data['key'] = strip_tags($req->input('key'));
        $model = new Cmdb();
        $list = $model->getAllByPage($data);
        $page = $list->setPath('')->appends($req->all())->render();
        return view('cmdb.index', compact('list', 'page', 'data'));
    }

    /*
     * 添加界面
     */
    public function addView(Request $req)
    {

        return view('cmdb.add');
    }

    /*
     * 保存编辑
     */
    public function store(Request $req)
    {
        $data = $req->all();
        $model = new Cmdb();
        $data['create_time'] = time();
        $validator = Validator::make($data , [
            'key' => 'required|unique:tb_setting|max:255',
            'value' => 'required',
        ] ,[
            'key.required' => '键不能为空',
            'key.unique' => '键已存在',
            'key.max' => '键超出范围',
            'value.required' => '值不能为空',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all() ;
            $this->respJsonResult(0, $errors[0]);
        }

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
    public function del($id){
        $status =  Cmdb::where('id',intval($id))->delete();
        if ($status !== false) {
            $this->respJsonResult(1, '删除成功！');
        } else {
            $this->respJsonResult(0, '删除失败！');
        }
    }

    /*
     * 编辑
     */
    public function update(Request $req)
    {
        $data = $req->all();
        $id =$data['id'];
        $model = new Cmdb();
        $validator = Validator::make($data , [
            'key' =>  ['required',
            Rule::unique('tb_setting')->ignore($id),
            'max:255',
            ],
            'value' => 'required',
        ],['key.required' => 0,
            'key.unique' => 1,
            'key.max' => 2,
            'value.required' => 3,
        ]);
        unset($data['_token']);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $this->respJsonResult(0, $errors[0]);
        }
        $status = $model->updateOne($id ,$data);
        if ($status !== false) {
            $this->respJsonResult(1, 'ok！');
        } else {
            $this->respJsonResult(0, 'error！');
        }
    }
}
