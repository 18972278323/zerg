<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/28
 * Time: 14:58
 */

namespace app\lib\exception;


class ThemeMissingException extends BaseException
{
    public $httpCode = 400;
    public $msg = "请求的主题不存在了，请检查参数";
    public $errorCode = 50000;
}