<?php

namespace App\Models;
class Admin extends CommModel
{
    //
    protected $table = "tb_admin";

    public $timestamps = false;

    protected $fillable = [
        'admin_name', 'admin_account', 'admin_password', 'admin_salt', 'add_time', 'role','update_time'
    ];

    public static function getAdminInfo($user_name)
    {
        if (empty($user_name)) {
            return [];
        }
        $admData =  Admin::where('admin_account', $user_name)->first();
        return $admData;
    }


    /**
     * 取得所有的
     * parm $data array
     * @return array
     */
    public function getAllByPage($data)
    {
        $currentQuery = $this->leftJoin('tb_role', 'tb_admin.role', '=', 'tb_role.id');
        if(isset($data['account']) and ! empty($data['account'])) {
            $currentQuery->where('tb_admin.admin_account', $data['account']);
        }
        $result = $currentQuery->select(array('tb_admin.*','tb_role.name'))->orderBy('id', 'desc')->paginate(self::PAGE_NUMS);
        return $result;
    }
}
