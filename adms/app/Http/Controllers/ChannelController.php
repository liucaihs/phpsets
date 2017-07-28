<?php
/**
 * Created by PhpStorm.
 * User: amdin
 * Date: 2017/5/22
 * Time: 16:12
 */
namespace App\Http\Controllers;
use App\Models\Platform;
use Validator;
use App\Common\Regex;
use App\Models\Media;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class ChannelController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $req)
    {
        $data['name'] = strip_tags($req->input('name'));
        $data['id'] = intval($req->input('id'));
        $data['belong'] = strip_tags($req->input('belong'));
        $data['channel_type'] = strip_tags($req->input('channel_type'));
        $data['starttime'] = strip_tags($req->input('start_time'));
        $data['endtime'] = strip_tags($req->input('end_time'));
        $plat = Platform::all(['id' , 'name'])->sortBy("id");
        $model = new Media();
        $list = $model->getAllByPage($data);
        $page = $list->setPath('')->appends($req->all())->render();
        return view('channel.index', compact('list', 'page', 'data','plat'));
    }

    /*
     * 添加界面
     */
    public function addChannel(Request $req)
    {
        $plat = Platform::all(['id' , 'name'])->sortBy("id");
        return view('channel.add', ['plat' => $plat]);
    }

    /*
     * 保存编辑
     */
    public function store(Request $req)
    {
        $data = $req->all();
        $model = new Media();
        $data['create_time'] = time();
        $validator = Validator::make($data , [
            'name' => 'required|unique:tb_media|max:255',
        ] ,[
            'name.required' => '媒体名称不能为空',
            'name.unique' => '媒体名称已存在',
            'name.max' => '媒体名称长度超出范围',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all() ;
            $this->respJsonResult(0, $errors[0]);
        }
        $isPhone = Regex::IsPhone($data['phone']);
        if (!$isPhone) {
            $this->respJsonResult(0, '联系方式格式不正确！');
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
        $status =  Media::where('id',intval($id))->delete();
        if ($status !== false) {
            $this->respJsonResult(1, '删除成功！');
        } else {
            $this->respJsonResult(0, '删除失败！');
        }
    }

   /*
   *渠道下拉选择框
   */
    public function chlselect()
    {
        $data = Media::all(['id' , 'name'])->sortByDesc('create_time');
        echo json_encode($data);
    }

    /*
     * 编辑
     */
    public function update(Request $req , $id)
    {
         $model = new Media();
         if (!$req->isMethod("POST")) {
             $plat = Platform::all(['id' , 'name'])->sortBy("id");
             $data = $model->getOneById(intval($id));
             return view('channel.edit', ['row' => $data ,'plat' => $plat]);
         } else {
             $data = $req->all();
             unset($data['_token']);
             if (isset($data['create_time']) && !empty($data['create_time'])) {
                 $data['create_time'] = strtotime($data['create_time']);
             }
//             unset($data['create_time']);

             $validator = Validator::make($data , [
                     'name' => [
                         'required',
                          Rule::unique('tb_media')->ignore($id),
                         'max:255'
                     ]
             ]
            ,[
                 'name.required' => '媒体名称不能为空',
                 'name.unique' => '媒体名称已存在',
                 'name.max' => '媒体名称长度超出范围',
             ]);
             if ($validator->fails()) {
                 $errors = $validator->errors()->all() ;
                 $this->respJsonResult(0, $errors[0]);
             }
             $isPhone = Regex::IsPhone($data['phone']);
             if (!$isPhone) {
                 $this->respJsonResult(0, '联系方式格式不正确！');
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