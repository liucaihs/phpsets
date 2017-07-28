<?php
/**
 * User: cailiu
 * Date: 2017/6/28
 * Time: 14:41
 */
namespace proxy;

class CommProxy
{
    protected $logDir = __DIR__ . '/../log/';
    public function __construct()
    {
    }

    public static function http_post($url, $data, $timeout=20)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//20160721添加
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public static function http_get($url, $timeout=20)
    {
        $ctx = stream_context_create(array (
            'http' => array (
                'method'  => 'GET',
                'timeout' => $timeout
            )
        ));

        $result = file_get_contents($url, false, $ctx);
        return $result;
    }

    public static function http_curl_get($url, $timeout=20)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public function log_msg($msg){
        if (!file_exists($this->logDir)) {
            mkdir($this->logDir , 0777);
        }
        $log_file = $this->logDir . date('Y-m-d') . '.log';
        $date = date('Y-m-d H:i:s');
        $log = "$date # $msg" . PHP_EOL;
        file_put_contents($log_file, $log, FILE_APPEND);
    }
}