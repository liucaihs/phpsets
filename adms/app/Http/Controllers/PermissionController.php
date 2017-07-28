<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use Validator;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    //
    public function __construct()
    {

    }

    public function index(Request $req)
    {

        $data['name'] = strip_tags($req->input('name'));
        $model = new Permission();
        $list = $model->getAllByPage($data);
        $page = null;

        return view('permission.index', compact('list', 'page', 'data'));
    }

    /*
     * 添加界面
     */
    public function addView(Request $req)
    {
        $role = Permission::where('fid', 0)->orderBy('sort', 'asc')->orderBy('id', 'asc')->get(['id','display_name as name']);
        return view('permission.add', [ 'role' => $role]);
    }

    /*
     * 保存编辑
     */
    public function store(Request $req)
    {
        $data = $req->all();
        $model = new Permission();

        $validator = Validator::make($data , [
            'display_name' => 'required|unique:tb_permissions|max:50',
        ] ,[
            'display_name.required' => '显示名称不能为空',
            'display_name.unique' => '显示名称已存在',
            'display_name.max' => '显示名称长度超出范围',

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
        $status =  Permission::where('id',intval($id))->delete();
        if ($status !== false) {
            $this->respJsonResult(1, '删除成功！');
        } else {
            $this->respJsonResult(0, '删除失败！');
        }
    }

    /*
     * 编辑
     */
    public function update(Request $req , $id)
    {
        $model = new Permission();
        if (!$req->isMethod("POST")) {
            $data = $model->getOneById(intval($id));
            $role = Permission::where('fid', 0)->orderBy('sort', 'asc')->orderBy('id', 'asc')->get(['id','display_name as name']);
            return view('permission.edit', ['row' => $data , 'role' => $role]);
        } else {
            $data = $req->all();
            unset($data['_token']);
            $validator = Validator::make($data , [
                    'display_name' => [
                        'required',
                        Rule::unique('tb_permissions')->ignore($id),
                        'max:50'
                    ],
                ]
                ,[
                    'display_name.required' => '显示名称不能为空',
                    'display_name.unique' => '显示名称已存在',
                    'display_name.max' => '显示名称长度超出范围',
                ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all() ;
                $this->respJsonResult(0, $errors[0]);
            }

            $status =  $model->updateOne($id , $data);
            if ($status !== false) {
                $this->respJsonResult(1, '编辑成功！');
            } else {
                $this->respJsonResult(0, '编辑失败！');
            }
        }
    }
}
