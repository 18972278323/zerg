<?php


namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;

class Category
{
    /**
     * 查询分类列表
     * @return CategoryModel[]|false
     * @throws \think\exception\DbException
     */
    public function getCategoryList()
    {
        $catList = CategoryModel::all([],['topicImg']);

        if($catList->isEmpty()){
            throw new CategoryMissingException();
        }else{
            return $catList;
        }
    }

}