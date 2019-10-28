<?php


namespace app\lib\exception;


class CategoryMissingException extends BaseException
{
    public $httpCode = 400;
    public $msg = "请求的分类不存在";
    public $errorCode = 50000;
}