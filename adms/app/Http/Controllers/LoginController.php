<?php
/**
 * Created by PhpStorm.
 * User: amdin
 * Date: 2017/5/18
 * Time: 10:11
 */
namespace App\Http\Controllers;

use App\Admin;
use App\Models\Roleperm;
use Illuminate\Http\Request;
use Session,URL;
class LoginController extends Controller
{
    public function __construct()
    {

    }



    public function login()
    {
        return view('login.login', []);
    }

    /*
     * 登录验证
     */
    public function loginPost(Request $req)
    {
        $user_name = trim($req->input('username', ''));
        $password = trim($req->input('password', ''));
        $rolePerm = new  Roleperm();
        $data = Admin::getAdminInfo($user_name);
        if (empty($data)) {
            $this->respJsonResult(0, '用户账户不存在！');
        }
        if ($data->admin_password != md5($password)) {
            $this->respJsonResult(0, '密码不正确！');
        }
        $data->last_login = time();
        $data->save();
        $data->admin_password = "";
        $roPerm = $rolePerm->getRolePrim(['' => $data->role]);
        $data = $data->toArray();
        $data['allow'] = $roPerm;
        Session::put('admuser', $data);
//        Session::push('admuser.allow', $roPerm);
//        Session::put('admuser.allow', $roPerm);
        Session::save();
        $this->respJsonResult(1, '登录成功！');

    }

    /*
     * 退出登录
     */
    public function logout(Request $req)
    {
        $req->session()->flush();
        return redirect('login');
    }

    /*
     * 403
     */
    public function noPrimsion(Request $req)
    {
        $previousUrl = URL::previous();
        return view('errors.403', compact('previousUrl'));
    }
}