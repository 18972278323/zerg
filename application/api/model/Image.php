<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/28
 * Time: 10:27
 */

namespace app\api\model;


use think\Config;

class Image extends BaseModel
{
    protected $visible = ['url'];

    // 获取器修改 url路径
    public function getUrlAttr($value)
    {
        return $this->prefixImgUrl($value);
    }

}