<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/28
 * Time: 13:15
 */

namespace app\api\model;


class Product extends BaseModel
{
    protected $hidden = ['pivot','from','category_id','main_img_id','delete_time','update_time','create_time'];

    // 查询构造器修改图片路径
    protected function getMainImgUrlAttr($value)
    {
        return $this->prefixImgUrl($value);
    }

    public function images()
    {
        return $this->hasMany('ProductImage','product_id','id');
    }

    public function properties()
    {
        return $this->hasMany('ProductProperty','product_id','id');
    }
}