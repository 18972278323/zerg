<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/29
 * Time: 12:05
 */

namespace app\api\service;


use think\Config;

class BaseService
{
    /**
     * @return string Token令牌
     */
    protected static function genToken()
    {
        $randStr = getRandStr(32);
        $time = time();
        $salt = Config::get('secure.token_salt');

        return md5( $randStr . $time . $salt);
    }
}