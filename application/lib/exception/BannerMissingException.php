<?php


namespace app\lib\exception;


class BannerMissingException extends BaseException
{
    public $httpCode = 400;
    public $msg = "请求的Banner不存在";
    public $errorCode = 40000;
}