<?php
/**
 * User: cailiu
 * Date: 2017/6/21
 * Time: 10:04
 */
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $_monCon = null;
    private $_dbCon = null;
    private $_collCon = null;
    public function __construct()
    {
        //
        $mongoHost = env('MONGO_HOST');
        $this->_monCon =  new \MongoClient("mongodb://{$mongoHost}:27017" , ["connect" => true ] ); // 连接MongoDB
        $this->_dbCon = $this->_monCon->storage; // 选择数据库
        $this->_collCon = $this->_dbCon->getGridFS(); // 取得gridfs对象
    }

    //
    public function uploadRecv(Request $req , $name , $md5)
    {
        $streamData = isset($GLOBALS['HTTP_RAW_POST_DATA'])? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
        if(empty($streamData)){
            $streamData = file_get_contents('php://input');
        }
        $fileMd5Str = md5($streamData);
        if (empty($streamData) || $md5 != $fileMd5Str ) {
            $this->responseJson(0 , 'The file MD5 is not consistent');
        }
        $fileRecord = $this->_collCon->findOne(array('filename'=> $name)); // 以_id为索引取得文件
        if (!empty($fileRecord->file)) {
            header("HTTP/1.1 302 Found");
            exit;
        }
        //// gridfs有三种方式存储文件
        // 第一种直接存储文件   $id = $collection->storeFile("./logon.jpg");
        // 第二种存储文件二进制流    $data = file_get_contents("./logon.jpg");
        $id = $this->_collCon->storeBytes($streamData,array("filename" => $name ));
        if ($id) {
            $this->responseJson();
        } else {
            header("HTTP/1.1 404 Not Found");
            exit;
        }
    }

    public function downFile(Request $req , $name)
    {
        if (!empty($name)) {
            $fileRecord = $this->_collCon->findOne(array('filename'=> $name)); // 以_id为索引取得文件
            if (!empty($fileRecord->file)) {
                $fileData = $fileRecord->file;
                Header("Content-type: application/octet-stream");
                Header("Accept-Ranges: bytes");
                Header("Accept-Length:" . $fileData['length']);
                Header("Content-Disposition: attachment; filename=" . $fileData['filename']);
                echo  $fileRecord->getBytes();
            } else {
                header("HTTP/1.1 404 Not Found");
                exit;
            }
        } else {
            header("HTTP/1.1 404 Not Found");
            exit;
        }
    }

    public function fileExist(Request $req , $name)
    {
        if (!empty($name)) {
            $fileRecord = $this->_collCon->findOne(array('filename'=> $name)); // 以_id为索引取得文件
            if (!empty($fileRecord->file)) {
                $fileData = $fileRecord->file;
                $result['md5'] = $fileData['md5'];
                $result['length'] = $fileData['length'];
                echo json_encode( $result , JSON_UNESCAPED_UNICODE);
            } else {
                header("HTTP/1.1 404 Not Found");
                exit;
            }
        } else {
            header("HTTP/1.1 404 Not Found");
            exit;
        }
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
//        $this->_monCon->close();
    }
}