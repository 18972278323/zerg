<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/29
 * Time: 12:15
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $httpCode = 400;
    public $msg = "Token无效或已过期";
    public $errorCode = 40001;
}