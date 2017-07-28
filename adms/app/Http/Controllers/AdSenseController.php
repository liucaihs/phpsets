<?php
/**
 * Created by PhpStorm.
 * User: m
 * Date: 2017/5/27
 * Time: 14:12
 */
namespace App\Http\Controllers;
use Validator;
use App\Common\Regex;
use App\Models\AdSenseAdSense;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class AdSenseController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $req)
    {
        $data['advertiser'] = strip_tags($req->input('advertiser'));
        $data['client_ID'] = intval($req->input('client_ID'));

        $model = new AdSense();
        $list = $model->getAdverTiser($data);
        $page = $list->setPath('')->appends($req->all())->render();
        return view('adSense.index', compact('list', 'page', 'data'));
    }

    public function addindex(Request $req)
    {
        return view('adSense.add', []);
    }

    public function store(Request $req)
    {
        $data = $req->all();
        $model = new AdSense();
        $validator = Validator::make($data , [
            'name' => 'required|unique:tb_advertiser|max:255',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all() ;
            $this->respJsonResult(0, $errors[0]);
        }
        // $isPhone = Regex::IsPhone($data['phone']);
        // if (!$isPhone) {
        //     $this->respJsonResult(0, 'phone no！');
        // }
        $status = $model->addCommon($data);
        if ($status !== false) {
            $this->respJsonResult(1, 'ok！');
        } else {
            $this->respJsonResult(0, 'error！');
        }
    }

    public function delete($id){
        $status =  AdSense::where('id',intval($id))->delete();
        if ($status !== false) {
            $this->respJsonResult(1, 'delete！');
        } else {
            $this->respJsonResult(0, 'no delete！');
        }
    }

    public function update(Request $req)
    {

        $data = $req->all();
        $id =$data['id'];
        $model = new AdSense();
        $validator = Validator::make($data , [
            'name' =>  'required',
            Rule::unique('tb_advertiser')->ignore($id),
            'max:255'] //'required|unique:tb_advertiser|max:255',
         );
        unset($data['_token']);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $this->respJsonResult(0, $errors[0]);
        }
        $isPhone = Regex::IsPhone($data['phone']);
        if (!$isPhone) {
            $this->respJsonResult(0, 'phone no！');
        }

        $status = $model->updateOne($id ,$data);
        if ($status !== false) {
            $this->respJsonResult(1, 'ok！');
        } else {
            $this->respJsonResult(0, 'error！');
        }
    }
}