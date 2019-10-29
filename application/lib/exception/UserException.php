<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/29
 * Time: 16:28
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $httpCode = 400;
    public $msg = "该用户不存在，非法操作";
    public $errorCode = 70000;
}