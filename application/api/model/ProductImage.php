<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/29
 * Time: 14:16
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ["img_id", "delete_time", "product_id"];

    public function imgUrl()
    {
        return $this->belongsTo('Image','img_id','id');
    }
}