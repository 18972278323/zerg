<?php


namespace app\lib\exception;


class OrderException extends BaseException
{
    public $httpCode = 400;
    public $msg = "订单状态异常";
    public $errorCode = 80000;
}