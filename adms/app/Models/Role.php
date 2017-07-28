<?php

namespace App\Models;
class Role extends CommModel
{
    //
    protected $table = "tb_role";

    public $timestamps = false;

    protected $fillable = [ 'name', 'create_time', 'update_time' , 'description'];

    public function getAllByPage($data)
    {
        $currentQuery = $this->orderBy('id', 'asc');
        if (isset($data['name']) and !empty($data['name'])) {
            $currentQuery->where('name' ,'like', "%" .$data['name'] ."%"  ); ;//'like', "%" . $data['name'] . "%");
        }
        $result = $currentQuery->get()->toArray();// ->paginate(self::PAGE_NUMS);

        return $result;
    }

}
