<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/29
 * Time: 15:57
 */

namespace app\api\validate;


class AddressNew extends BaseValidate
{
    protected $message = [
        'name'  => '收件人姓名不能为空',
        'mobile'  => '收件人电话不能为空',
        'province'  => '收件人省份不能为空',
        'city'  => '收件人城市不能为空',
        'country'  => '收件人县/区不能为空',
        'detail'  => '收件人地址详情不能为空',

    ];

    protected $rule = [
        'name'  => 'require|isNotEmpty',
        'mobile'  => 'require|isNotEmpty',
        'province'  => 'require|isNotEmpty',
        'city'  => 'require|isNotEmpty',
        'country'  => 'require|isNotEmpty',
        'detail'  => 'require|isNotEmpty',
    ];
}