<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/28
 * Time: 16:35
 */

namespace app\api\controller\v1;


use app\api\validate\LimitCount;
use app\api\model\Product as ProductModel;
use app\lib\exception\ProductMissingException;

class Product
{
    /**
     * 获取最近商品列表
     * @url product/recent?count=10
     */
    public function getRecent($count = 10)
    {
        (new LimitCount())->goCheck();

        $proList =  ProductModel::limit($count)->order('create_time','DESC')->select();

        if($proList){
            return $proList;
        }else{
            throw new ProductMissingException();
        }
    }
}