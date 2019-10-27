<?php


namespace app\api\controller\v1;


use app\api\validate\IDMustBePositiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissingException;
use think\Exception;

class Banner
{
    /**
     * @url /banner/:id
     * @method GET
     * @param $id Banner的ID
     * @return banner相关数据
     * @throws
     */
    public function getBannerById($id)
    {

        (new IDMustBePositiveInt())->goCheck();

        $banner = BannerModel::getBannerById($id);

        if ($banner) {
            return $banner;
        }else{
            throw new BannerMissingException();
        }
    }
}