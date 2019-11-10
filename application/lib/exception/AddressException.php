<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/29
 * Time: 17:10
 */

namespace app\lib\exception;


class AddressException extends BaseException
{
    public $httpCode = 400;
    public $msg = "地址保存失败";
    public $errorCode = 71000;
}