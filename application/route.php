<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

Route::get('api/:version/banner/:id','api/:version.Banner/getBannerById');

Route::get('api/:version/theme', 'api/:version.Theme/getThemeListById');
Route::get('api/:version/theme/:id', 'api/:version.Theme/getThemeOneById');

Route::get('api/:version/product/recent', 'api/:version.Product/getRecent');
Route::get('api/:version/product/:id', 'api/:version.Product/getOneDetail',[],['id'=>'\d+']);

Route::get('api/:version/category/all', 'api/:version.Category/getCategoryList');
Route::get('api/:version/category/:id', 'api/:version.Product/getAllInCategory');

Route::post('api/:version/token/user', 'api/:version.Token/getToken');

Route::post('api/:version/address/save', 'api/:version.Address/saveAddress');
