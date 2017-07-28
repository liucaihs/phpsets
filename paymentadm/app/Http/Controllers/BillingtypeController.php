<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use App\Models\Codetypes;
use Illuminate\Validation\Rule;

class BillingtypeController extends Controller
{
    //
    protected $_valiMsg = [
        'codetype.required' => '编号不能为空',
        'codetype.unique' => '编号已存在',
        'codetype.integer' => '编号必须是整数',

    ];
    public function __construct()
    {

    }

    public function index(Request $req)
    {

        $data['name'] = strip_tags($req->input('name', ''));
        $data['spid'] = strip_tags($req->input('spid', ''));
        $model = new Codetypes();
        $curQuery =  $model->leftJoin('sps', 'codetypes.spid', '=', 'sps.id');
        $curQuery->select(array('codetypes.*','sps.name'));
        if (!empty( $data['name'])) {
            $curQuery->where('codetypes.codetype', 'like', '%' . $data['name'] . '%');
        }
        if (!empty( $data['spid'])) {
            $curQuery->where('codetypes.spid',  $data['spid']  );
        }
        $curQuery->orderBy('codetypes.updated_at', 'desc')->orderBy('codetypes.id', 'desc');
        $list = $curQuery->paginate(config('app.PAGE_NUMS'));
        $page = $list->setPath('')->appends($req->all())->render();
        return view('billing.index', compact('list', 'page', 'data'));
    }

    public function saveInsert(Request $req)
    {
        $id = intval($req->input('id', ''));
        $model = new Codetypes();
        $inputs = array_only($req->all(), $model->getFillable());

        if ($id > 0) {
            $validator = Validator::make($inputs, [
                'codetype' => [
                    'required',
                    'integer',
                    Rule::unique('codetypes')->ignore($id),
                ],

            ], $this->_valiMsg);
            $this->validatorFails($validator);

            $status = Codetypes::where('id', $id)->update($inputs);;
        } else {
            $validator = Validator::make($inputs, [
                'codetype' => 'required|integer|unique:codetypes',

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
        $status = Codetypes::where('id', intval($id))->delete();
        if ($status !== false) {
            $this->respJsonResult(1, '删除成功！');
        } else {
            $this->respJsonResult(0, '删除失败！');
        }
    }
}