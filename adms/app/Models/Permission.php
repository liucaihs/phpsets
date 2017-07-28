<?php

namespace App\Models;


class Permission extends CommModel
{
    //
    protected $table = "tb_permissions";
    public $timestamps = false;

    protected $fillable = [
        'name', 'fid', 'display_name', 'description', 'is_menu', 'sort', 'create_time' , 'update_time',
    ];

    public function getAllByPage($data)
    {
        $currentQuery = $this->orderBy('sort', 'asc');
        if (isset($data['name']) and !empty($data['name'])) {
            $currentQuery->where('display_name' ,'like', "%" .$data['name'] ."%"  );//'like', "%" . $data['name'] . "%");
        }
        $result = $currentQuery->get()->toArray();// ->paginate(self::PAGE_NUMS);
        $backData = [];
        $this->dataLevelSort($backData , 0 , $result );
        return $backData;
    }

    protected function dataLevelSort(&$backData, $fid = 0, $result, $lev = 0)
    {
        foreach($result as $key => $val) {
            if ($val['fid'] == $fid) {
                $val['lev'] = $lev;
                $backData[] = $val;
                $result[$key] = null; unset($result[$key]);
                $this->dataLevelSort($backData, $val['id'], $result, $lev + 1);
            }
        }

    }

    public function getRolePerm($id)
    {
        $currentQuery = $this->orderBy('sort', 'asc')->orderBy('is_menu', 'desc');
        $result = $currentQuery->get()->toArray();
        $list = $this->dataLevelPerm( 0 , $result , $id);
        return $list;
    }

    protected function dataLevelPerm($fid = 0, $result, $roleid, $lev = 0)
    {
        $model = new Roleperm();
        $backData = [];
        foreach($result as $key => $val) {
            if ($val['fid'] == $fid) {
                $val['lev'] = $lev;
                $isHav =  $model->judgeRolePrim(['permission_id' => $val['id'] , 'role_id' => $roleid]);
                $val['is_chk'] = !empty($isHav) ? true : false;
                $val['sub_perm'] = $this->dataLevelPerm($val['id'], $result, $roleid , $lev + 1);
                $backData[] = $val;
                $result[$key] = null; unset($result[$key]);
            }
        }
        return $backData;
    }
}
