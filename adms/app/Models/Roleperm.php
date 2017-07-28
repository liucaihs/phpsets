<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roleperm extends CommModel
{
    protected $table = "tb_permission_role";

    public $timestamps = false;

    protected $fillable = [ 'permission_id','role_id'];

    public function judgeRolePrim($data)
    {
        $currentQuery = $this->select('*');
        if (isset($data['permission_id']) and !empty($data['permission_id'])) {
            $currentQuery->where('permission_id' , $data['permission_id']  );
        }
        if (isset($data['role_id']) and !empty($data['role_id'])) {
            $currentQuery->where('role_id' , $data['role_id'] );
        }
        $result = $currentQuery->get()->toArray();
        return $result;
    }

    public function getRolePrim($data)
    {
        $currentQuery = $this->select('tb_permissions.name')->leftJoin('tb_permissions', 'tb_permission_role.permission_id', '=', 'tb_permissions.id');
        if (isset($data['permission_id']) and !empty($data['permission_id'])) {
            $currentQuery->where('permission_id' , $data['permission_id']  );
        }
        if (isset($data['role_id']) and !empty($data['role_id'])) {
            $currentQuery->where('role_id' , $data['role_id'] );
        }
        $currentQuery->where('tb_permissions.name' ,'<>' , '#' );
        $routes = "";
        $result = $currentQuery->get()->toArray();
        foreach ($result as $item) {
            $routes .= $item['name'] .",";
        }
        return $routes;
    }


}


