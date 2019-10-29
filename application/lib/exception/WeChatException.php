<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/29
 * Time: 10:02
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $httpCode = 400;
    public $msg = "请求Token令牌异常";
    public $errorCode = 40000;

}