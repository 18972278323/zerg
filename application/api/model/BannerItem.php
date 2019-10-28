<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/28
 * Time: 10:00
 */

namespace app\api\model;


class BannerItem extends BaseModel
{
    // 隐藏无用字段
    protected $hidden = ['id','img_id','delete_time','update_time'];

    public function image()
    {
        return $this->belongsTo('Image','img_id','id');
    }
}