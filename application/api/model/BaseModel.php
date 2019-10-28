<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/28
 * Time: 12:46
 */

namespace app\api\model;


use think\Model;
use think\Config;

class BaseModel extends Model
{
    // 获取器修改 url路径
    protected function prefixImgUrl($value)
    {
        $domain = Config::get('setting.image_prefix');
        return $domain . $value;
    }
}