<?php
/**
 * User: cailiu
 * Date: 2017/6/27
 * Time: 17:11
 */

require_once __DIR__ . '/config.php';

foreach ($redisSet as $redis) {
    if ($redis instanceof Predis\Client) {
        $numbers = $redis->zremrangebyscore(KDL_LIST, strtotime("-7 day"), time());
    }
}
echo "start ". strtotime("-7 day") ." removed {$numbers} ip finished";


