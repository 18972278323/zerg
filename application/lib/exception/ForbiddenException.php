<?php


namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $httpCode = 403;
    public $msg = "没有访问权限";
    public $errorCode = 10001;
}