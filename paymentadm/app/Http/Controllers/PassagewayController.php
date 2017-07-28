<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use App\Models\Sps;
use Illuminate\Validation\Rule;

class PassagewayController extends Controller
{
    //
    protected $_valiMsg = [
        'name.required' => '通道名称不能为空',
        'name.unique' => '通道名称已存在',
        'name.max' => '通道名称超出范围',

    ];
    public function __construct()
    {

    }

    public function index(Request $req)
    {

        $data['name'] = strip_tags($req->input('name', ''));
        $model = new Sps();
        $list = $model->orderBy('updated_at', 'desc')->orderBy('id', 'desc')
            ->where('name', 'like', '%' . $data['name'] . '%')
            ->paginate(config('app.PAGE_NUMS'));
        $page = $list->setPath('')->appends($req->all())->render();
        return view('sps.index', compact('list', 'page', 'data'));
    }

    public function saveInsert(Request $req)
    {
        $id = intval($req->input('id', ''));
        $model = new Sps();
        $inputs = array_only($req->all(), $model->getFillable());

        if ($id > 0) {
            $validator = Validator::make($inputs, [
                'name' => [
                    'required',
                    Rule::unique('sps')->ignore($id),
                    'max:64'
                ],

            ], $this->_valiMsg);
            $this->validatorFails($validator);

            $status = Sps::where('id', $id)->update($inputs);;
        } else {
            $validator = Validator::make($inputs, [
                'name' => 'required|unique:sps|max:64',

            ], $this->_valiMsg);
            $this->validatorFails($validator);

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
        $status = Sps::where('id', intval($id))->delete();
        if ($status !== false) {
            $this->respJsonResult(1, '删除成功！');
        } else {
            $this->respJsonResult(0, '删除失败！');
        }
    }

    /*
   *渠道下拉选择框
   */
    public function passselect()
    {
        $data = Sps::orderBy('updated_at', 'desc')->orderBy('id', 'desc')->get(['id' , 'name']);
        echo json_encode($data);
    }
}