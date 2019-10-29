<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/28
 * Time: 16:35
 */

namespace app\api\controller\v1;


use app\api\validate\IDMustBePositiveInt;
use app\api\validate\LimitCount;
use app\api\model\Product as ProductModel;
use app\lib\exception\ProductMissingException;

class Product
{
    /**
     * 获取最近商品列表
     * @url product/recent?count=10
     * @param int 查询最新商品的数量
     * @return 最新商品列表
     * @throws
     */
    public function getRecent($count = 10)
    {
        (new LimitCount())->goCheck();

        $proList =  ProductModel::limit($count)->order('create_time','DESC')->select();

        if($proList->isEmpty()){
            throw new ProductMissingException();
        }else{
            return $proList;
        }
    }

    /**
     * @param $id   分类ID
     * @return false|\PDOStatement|string|\think\Collection 指定分类下的商品
     * @throws
     */
    public function getAllInCategory($id)
    {
        (new LimitCount())->goCheck();

        $proList = ProductModel::where('category_id', '=', $id)->select();

        if($proList->isEmpty()){
            throw new ProductMissingException();
        }else{
            return $proList;
        }
    }

    /**
     * 查询商品详情
     * @url product/id
     * @return array
     * @param 商品id
     * @throws
     */
    public function getOneDetail($id)
    {
        (new IDMustBePositiveInt())->goCheck();

//        $proDetail = ProductModel::with(['properties','images.imgUrl'])
        $proDetail = ProductModel::with(['properties'])
            ->with([ 'images'=>function($query){
                        $query->with('imgUrl')->order('order','ASC');
                }])
            ->find($id);

        if(!$proDetail){
            throw new ProductMissingException();
        }else{
            return $proDetail;
        }
    }


}