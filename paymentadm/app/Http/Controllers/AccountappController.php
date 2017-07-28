<?php
/**
 * Created by PhpStorm.
 * User: amdin
 * Date: 2017/5/23
 * Time: 15:18
 */
namespace App\Http\Controllers;

use App\Models\AccountAppids;
use Mockery\CountValidator\Exception;
use Validator;
use App\Models\Admin;
use App\Models\Appids;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountappController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $req)
    {

        $data['account'] = strip_tags($req->input('account', ''));
        $model = new Admin();
        $list = $model->getAccountByPage($data);
        $page = $list->setPath('')->appends($req->all())->render();

        foreach ($list as $key => $val) {
            $appids = AccountAppids::getAccountIds($val->id);
            $list[$key]['appids'] = implode(PHP_EOL , $appids);
        }
        return view('account.appids', compact('list', 'page', 'data'));
    }


    /*
     * 编辑
     */
    public function update(Request $req)
    {
        $data = $req->all();
        $appidstr = str_replace(' ', ',' ,$data['desc']);
        $appidstr = preg_replace('/\s+/', ',', $appidstr);
        $appidstr = str_replace(PHP_EOL, ',' , $appidstr);
        $appids = explode(',' , $appidstr );
        if (empty($data['id']) || empty($appids)) {
            $this->respJsonResult(0, '编辑失败！');
        }
        $insData = [];

        $appids = array_unique($appids);
        foreach ($appids as $key => $val) {
            if(!empty($val)) {
                $appidOne = Appids::where('appid' , $val)->first();
                if (empty($appidOne)) {
                    $this->respJsonResult(0,  'appid（' . $val . '）不存在！');
                }
                $insData[$key]['appid'] = $val;
                $insData[$key]['account_id'] = $data['id'];
            }
        }
        DB::beginTransaction();
        try {
            AccountAppids::where('account_id', $data['id'])->delete();
            AccountAppids::insert($insData);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->respJsonResult(0, '操作失败！'. $e->getMessage());
        }
        $status =  1;
        if ($status !== false) {
            $this->respJsonResult(1, '操作成功！');
        } else {
            $this->respJsonResult(0, '操作失败！');
        }
    }

}