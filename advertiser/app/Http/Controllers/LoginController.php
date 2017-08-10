<?php
/**
 * Created by PhpStorm.
 * User: ming
 * Date: 2017/7/28
 * Time: 15:28
 */
namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Session,URL;
use Illuminate\Support\Facades\DB;

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
        $user_name = trim($req->input('account', ''));
        $password = trim($req->input('password', ''));
        $data = Admin::getAdminInfo($user_name);
        if (empty($data)) {
            $this->respJsonResult(0, '用户账户不存在！');
        }
        if ($data->password != md5($password)) {
            $this->respJsonResult(0, '密码不正确！');
        }
        // $data->last_login = time();
        $data->save();
        $data->password = "";
        $data = $data->toArray();
        $data['account'] = $user_name;//录入账户
        Session::put('admuser', $data);
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

    public function acconut_id()
    {
        $site = session('admuser.account');
        $ret = DB::select('select id,name FROM tb_advertiser WHERE account = ?', [$site]);
        echo json_encode($ret);
    }
}