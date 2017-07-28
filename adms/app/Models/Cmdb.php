<?php

namespace App\Models;
class Cmdb extends CommModel
{
    //
    protected $table = "tb_setting";

    public $timestamps = false;

    protected $fillable = [ 'key','value','create_time','update_time'];

    public function getAllByPage($data)
    {
        $currentQuery = $this->orderBy('id', 'asc');
        if (isset($data['key']) and !empty($data['key'])) {
            $currentQuery->where('key' ,'like', "%" .$data['key'] ."%"  );
        }
        $result = $currentQuery->paginate(self::PAGE_NUMS);

        return $result;
    }

}
