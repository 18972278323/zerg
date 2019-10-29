<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/29
 * Time: 17:08
 */

namespace app\lib\exception;


class SuccessMessage extends BaseException
{
    public $httpCode = 200;
    public $msg = "操作成功";
    public $errorCode = 0;

}