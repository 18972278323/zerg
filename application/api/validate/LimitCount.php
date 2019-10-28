<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/28
 * Time: 16:36
 */

namespace app\api\validate;


class LimitCount extends BaseValidate
{
    protected $message = [
        'count' => [
            'isPositiveInt' => 'count必须为正整数',
            'between'       => 'count最大值为20',
        ]
    ];

    protected $rule = [
        'count' => 'isPositiveInt|between:1,20'
    ];
}