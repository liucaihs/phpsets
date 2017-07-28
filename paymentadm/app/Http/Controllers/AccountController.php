<?php
/**
 * Created by PhpStorm.
 * User: amdin
 * Date: 2017/5/23
 * Time: 15:18
 */
namespace App\Http\Controllers;
use App\Models\Role;
use Validator;
use App\Models\Admin;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class AccountController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $req)
    {

        $data['account'] = strip_tags($req->input('account',''));
        $model = new Admin();
        $list = $model->getAllByPage($data);
        $page = $list->setPath('')->appends($req->all())->render();

        return view('account.index', compact('list', 'page', 'data'));
    }

    /*
     * 添加界面
     */
    public function addView(Request $req)
    {
        $role = Role::all(['id' , 'name'])->sortBy("id");
        return view('account.add', [ 'role' => $role]);
    }

    /*
     * 保存编辑
     */
    public function store(Request $req)
    {
        $data = $req->all();
        $model = new Admin();
        $data['create_time'] = time();
        $validator = Validator::make($data , [
            'admin_account' => 'required|unique:admin|max:25',
            'admin_password' => 'required|max:25|min:6',
        ] ,[
            'admin_account.required' => '登录账号不能为空',
            'admin_account.unique' => '登录账号已存在',
            'admin_account.max' => '登录账号长度超出范围',
            'admin_password.max' => '登录密码长度超出范围',
            'admin_password.min' => '登录密码长度不够',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all() ;
            $this->respJsonResult(0, $errors[0]);
        }
        if (empty($data['admin_password'])) {
            unset($data['admin_password']);
        } else {
            $data['admin_password'] = md5($data['admin_password']);
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
        $status =  Admin::where('id',intval($id))->delete();
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
        $model = new Admin();
        if (!$req->isMethod("POST")) {
            $data = $model->getOneById(intval($id));
            $role = Role::all(['id' , 'name'])->sortBy("id");
            return view('account.edit', ['row' => $data , 'role' => $role]);
        } else {
            $data = $req->all();
            unset($data['_token']);
            $validator = Validator::make($data , [
                    'admin_account' => [
                        'required',
                        Rule::unique('admin')->ignore($id),
                        'max:25'
                    ],
                    'admin_password' => 'max:25',
                ]
                ,[
                    'admin_account.required' => '登录账号不能为空',
                    'admin_account.unique' => '登录账号已存在',
                    'admin_account.max' => '登录账号长度超出范围',
                    'admin_password.max' => '登录密码长度超出范围',
                ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->all() ;
                $this->respJsonResult(0, $errors[0]);
            }
            if (empty($data['admin_password'])) {
                unset($data['admin_password']);
            } else {
                if (strlen($data['admin_password']) < 6) {
                    $this->respJsonResult(0, "密码长度不够");
                }
                $data['admin_password'] = md5($data['admin_password']);
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