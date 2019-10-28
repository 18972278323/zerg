<?php


namespace app\api\validate;


class IDMustBePositiveInt extends BaseValidate
{

    protected $message = [
        'id'    => [
            'require'   => 'id参数为必须值',
            'isPositiveInt' =>  'id必须是正整数',
        ]
    ];
    protected $rule = [
        'id' => 'require|isPositiveInt',
    ];

}