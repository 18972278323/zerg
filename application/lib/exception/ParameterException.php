<?php


namespace app\lib\exception;

use Throwable;

class ParameterException extends BaseException
{
    public $httpCode = 400;
    public $msg = "参数错误";
    public $errorCode = 10002;

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