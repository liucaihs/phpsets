<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Roleperm;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    //
    public function __construct()
    {

    }

    public function index(Request $req)
    {

        $data['name'] = strip_tags($req->input('name'));
        $model = new Role();
        $list = $model->getAllByPage($data);
        $page = null;

        return view('role.index', compact('list', 'page', 'data'));
    }

    /*
     * 添加界面
     */
    public function addView(Request $req)
    {

        return view('role.add');
    }

    /*
     * 保存编辑
     */
    public function store(Request $req)
    {
        $data = $req->all();
        $model = new Role();
        $data['create_time'] = time();
        $validator = Validator::make($data , [
            'name' => 'required|unique:role|max:50',
        ] ,[
            'name.required' => '角色名称不能为空',
            'name.unique' => '角色名称已存在',
            'name.max' => '角色名称长度超出范围',

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
        $status =  Role::where('id',intval($id))->delete();
        if ($status !== false) {
            Permission::where('id',intval($id))->delete();
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
        $model = new Role();
        if (!$req->isMethod("POST")) {
            $data = $model->getOneById(intval($id));

            return view('role.edit', ['row' => $data ]);
        } else {
            $data = $req->all();
            unset($data['_token']);
            $validator = Validator::make($data , [
                    'name' => [
                        'required',
                         Rule::unique('role')->ignore($id),
                        'max:50'
                    ],
                    'admin_password' => 'max:15',
                ]
                ,[
                    'display_name.required' => '角色名称不能为空',
                    'display_name.unique' => '角色名称已存在',
                    'display_name.max' => '角色名称长度超出范围',
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

    //Role Permission
    public function permissions(Request $req , $id)
    {
        $permRef = new Permission();
        $model = new Role();
        if (!$req->isMethod("POST")) {
            $data = $model->getOneById(intval($id));
            $permList = $permRef->getRolePerm($id);
            return view('role.permissions', compact('data', 'permList'));
        } else {
            $data = $req->all();
            $data = $data['permissions'];
            $permArr = [];
            array_walk($data, function($v, $k) use (&$permArr,$id){
                array_push($permArr , [ 'permission_id' => $v  , 'role_id' => $id]);
            });

            try {
                DB::beginTransaction();
                Roleperm::where('role_id',intval($id))->delete();
                if (!empty($permArr)) {
                    DB::table('permission_role')->insert($permArr);
                }
                $model->updateOne($id , ['update_time' => time()]);
                DB::commit();
                $this->respJsonResult(1, '编辑成功！');
            } catch (\Exception $e) {
                DB::rollBack();
                $this->respJsonResult(0, '编辑失败！' .$e->getMessage());
//                throw new \Exception($e->getMessage());
            }
        }
    }
}
