<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 评论表模型
 *
 * @author jiang
 */
class CommModel extends Model
{
    /**
     * 每页多少
     *
     * @var int
     */
    CONST PAGE_NUMS = 15;

    /**
     * 关闭自动维护updated_at、created_at字段
     *
     * @var boolean
     */
    public $timestamps = false;
    /**
     * 根据ID取得内容
     * @param int $Id id
     * @return array
     */
    public function getOneById($id)
    {
        if (empty($id)) {
            return null;
        }
        return $this->where('id', $id)->first();
    }

    /**
     * 增加
     * @param $data array
     * @param array $data 所需要插入的信息
     */
    public function addCommon(array $data)
    {
        if (empty($data)) {
            return false;
        }
        if (!isset($data['create_time']) || empty($data['create_time'])) {
            $data['create_time'] = time();
        }
        return $this->create($data);
    }

    /**
     * 更新
     * @param int $Id id
     * @param $data array
     */
    public function updateOne($Id, $data)
    {
        if (empty($Id) || empty($data)) {
            return false;
        }
        if (!isset($data['update_time']) || empty($data['update_time'])) {
            $data['update_time'] = time();
        }
        return $this->where('id', '=', intval($Id))->update($data);
    }

    /**
     * 取得所有的
     *
     * @return array
     */
    public function getAllByPage($data)
    {
        $currentQuery = $this->orderBy('id', 'desc');
        $result = $currentQuery->paginate(self::PAGE_NUMS);
        return $result;
    }

    /*
    * 删除
    */

}
