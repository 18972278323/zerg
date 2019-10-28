<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/28
 * Time: 13:52
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $message = [
        'ids' => [
            'require'   => '缺失参数ids',
            'idsCheck'  => 'ids须为正整数，多值使用英文逗号分隔',
        ],
    ];

    protected $rule = [
        'ids' => 'require|idsCheck',
    ];

    protected function idsCheck($value)
    {
        $idsArray = explode(',', $value);
        if(empty($idsArray)){
            return false;
        }

        foreach ($idsArray as $id) {
            if(!$this->isPositiveInt($id)){
                return false;
            }
        }
        return true;
    }
}