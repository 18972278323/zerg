<?php


namespace app\lib\exception;


class ProductMissingException extends BaseException
{
    public $httpCode = 400;
    public $msg = "请求的商品不存在";
    public $errorCode = 20000;
}