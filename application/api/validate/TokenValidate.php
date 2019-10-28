<?php


namespace app\api\validate;


class TokenValidate extends BaseValidate
{   protected $message = [
        'code'  => [
            'require'   => 'code不可为空',
            'isNotEmpty'=> 'code不可为空',
        ]
    ];

    protected $rule = [
        'code'  => 'require|isNotEmpty'
    ];
}