<?php


namespace app\lib\exception;


use \Exception;
use think\Config;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    private $httpCode;
    private $msg;
    private $errorCode;

    // 代码中抛出的异常都会在这里处理
    public function render(Exception $e)
    {
        if($e instanceof BaseException){
            // 是客户端异常，需要返回客户端具体错误消息
            $this->httpCode = $e->httpCode;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        }else{
            // 服务器内部错误
            if(Config::get('app_debug')){
                // DEBUG true模式，返回框架原有的错误页面
                return parent::render($e);
            }else{
                // DEBUG false模，返回客户端简洁消息
                $this->httpCode = 500;
                $this->msg = "服务器内部错误";
                $this->errorCode = 999;

                // 记录日志
                $this->recodeLog($e);
            }
        }

        $res = [
            'msg' => $this->msg,
            'error_code'=> $this->errorCode,
            'request_url' => (Request::instance())->url(),
        ];
        return json($res,$this->httpCode);
    }

    /**
     * 记录异常日志
     * @param $e 异常
     */
    private function recodeLog($e)
    {
        Log::init([
            'type' => 'File',
            'path'  => LOG_PATH,
            'level' => ['error'],
        ]);
        Log::record($e->getMessage(), 'error');
    }

}