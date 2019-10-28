<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/28
 * Time: 13:13
 */

namespace app\api\controller\v1;


use app\api\validate\IDCollection;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ThemeMissingException;
use app\api\model\Theme as ThemeModel;

class Theme
{
    /**
     * 依据ID获取主体列表
     * @url theme?ids=1,2,3
     * @throws
     */
    public function getThemeListById($ids = '')
    {
        (new IDCollection())->goCheck();

        $themes = ThemeModel::with(['product','topicImg','headImg'])->select($ids);

        if ($themes->isEmpty()) {
            throw new ThemeMissingException();
        }else{
            return $themes;
        }
    }

    /**
     * @url theme/id
     */
    public function getThemeOneById($id)
    {
        (new IDMustBePositiveInt())->goCheck();

        $theme = ThemeModel::with(['product', 'topicImg', 'headImg'])->find($id);

        if ($theme) {
            return $theme;
        }else{
            throw new ThemeMissingException();
        }
    }
}