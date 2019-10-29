<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/29
 * Time: 14:16
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{

    protected $hidden = [  "id", "product_id", "delete_time", "update_time"];
//    public function imgUrl()
//    {
//        return $this->belongsTo('Image','img_id','id');
//    }
}