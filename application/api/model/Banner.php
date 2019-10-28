<?php


namespace app\api\model;


class Banner extends BaseModel
{
    // 隐藏无用字段
    protected $hidden = ['update_time','delete_time'];

    public function bannerItems()
    {
        return $this->hasMany('BannerItem','banner_id','id');
    }
}