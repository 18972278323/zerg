<?php


namespace app\api\validate;

use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    // 执行验证的通用方法
    public function goCheck()
    {
        $request = Request::instance();
        $params = $request->param();

        $res = $this->batch()->check($params);
        if (!$res) {
            throw new ParameterException([
                'httpCode'  => 400,
                'msg'   => $this->getError(),
                'errorCode' => 10002
            ]);
        }else{
            return true;
        }
    }

    // 验证正整数
    public function isPositiveInt($value,$rule='',$data=[],$field='')
    {
        if(is_numeric($value) && is_int($value + 0) && ($value + 0) >0 ){
            return true;
        }else{
            return false;
        }
    }

    // 字符串不为空
    public function isNotEmpty($value)
    {
        if( empty($value) ){
            return false;
        }else{
            return true;
        }
    }
}