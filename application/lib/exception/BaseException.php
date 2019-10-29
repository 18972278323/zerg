<?php


namespace app\lib\exception;
use think\Exception;


class BaseException extends Exception
{
    // HTTP状态码
    public $httpCode = 400;

    // 错误消息
    public $msg = "参数错误";

    // 自定义错误码
    public $errorCode = 10000;

    public function __construct($params = [])
    {
        if(!is_array($params)){
            return ;
        }

        if(array_key_exists('httpCode',$params)){
            $this->httpCode = $params["httpCode"];
        }
        if (array_key_exists('msg', $params)) {
            $this->msg = $params["msg"];
        }
        if (array_key_exists('errorCode', $params)) {
            $this->errorCode = $params["errorCode"];
        }
    }

}