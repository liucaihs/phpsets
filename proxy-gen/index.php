<?php
/**
 * User: cailiu
 * Date: 2017/6/27
 * Time: 17:07
 */
use proxy\KdlProxy;

require_once __DIR__ . '/config.php';


$kdlProxy = new KdlProxy();
$lists = $kdlProxy->getIpLists(KDL_ORDNO, 50);
print_r($lists);
function saveIp2Redis($redisSet, $lists, $expired = 10)
{
    if (empty($redisSet) || empty($lists)) {
        return;
    }
    $curtime = time();
    foreach ($redisSet as $redis) {
        if ($redis instanceof Predis\Client) {
            foreach ($lists as $val) {
                $addStat = $redis->zadd(KDL_LIST, $curtime + $expired * 60, $val);

            }
        }

    }
}

saveIp2Redis($redisSet, $lists);

echo "min " . strtotime(date("Y-m-d")) . ", max " . time();
echo "<pre>";
foreach ($redisSet as $redis) {
    if ($redis instanceof Predis\Client) {
        $kdlList = $redis->zrange(KDL_LIST, 0, 1000, ['withsocres']);
        print_r($kdlList);
    }

}



