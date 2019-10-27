<?php


namespace app\api\model;


use think\Exception;
use think\Model;

class Banner extends Model
{
    public static function getBannerById($id)
    {
        $banner = Banner::get($id);
        return $banner->toJson();
    }
}