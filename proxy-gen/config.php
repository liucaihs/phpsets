<?php
/**
 * User: cailiu
 * Date: 2017/6/27
 * Time: 16:56
 */
date_default_timezone_set('Asia/Shanghai');
define('BASEDIR', __DIR__);

define('REDIS_DB', 15);		// redis 端口
define('REDIS_PWD', '');		// redis 端口

define('KDL_ORDNO', '959431791343228');		//  快代理订单号
define('KDL_LIST', 'kdlsortset');		//  快代理订单号

require_once __DIR__ . '/vendor/autoload.php';

$single_server = array(
    'host' => '127.0.0.1' ,
    'port' => '6379',
    'database' => REDIS_DB,
//    'password'   => REDIS_PWD,
);

$redisSet[] = new Predis\Client($single_server, array('prefix' => ''));

$single_server = array(
    'host' => '127.0.0.1' ,
    'port' => '6381',
    'database' => REDIS_DB,
//    'password'   => REDIS_PWD,
);

$redisSet[] = new Predis\Client($single_server, array('prefix' => ''));

class Loader
{
    static function autoload($class)
    {
        require BASEDIR.'/'.str_replace('\\', '/', $class).'.php';
    }
}
spl_autoload_register('Loader::autoload');
