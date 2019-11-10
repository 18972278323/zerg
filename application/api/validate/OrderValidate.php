<?php


namespace app\api\validate;


use app\lib\exception\ParameterException;

class OrderValidate extends BaseValidate
{
    protected $rule = [
        'products' => 'checkProductList',
        'addressId'=> 'require|isPositiveInt|checkAddressId',
    ];

    protected $singleRule = [
        'id'    => 'require|isNotEmpty',
        'count' => 'require|isPositiveInt',
        'name'  => 'require|isNotEmpty',
    ];

    protected $message = [
        'id'    => '商品ID必须为正整数',
        'count' => '商品数量必须为正整数',
        'name'  => '商品名称不能为空',
        'addressId' => '地址信息不正确',
    ];

    // 检查订单商品数据格式
    protected function checkProductList($value)
    {
        if(count($value) > 0){
            foreach ($value as $oProduct){
                $res = $this->check($oProduct,$this->singleRule);
                if (!$res) {
                    // 拼接字符串错误信息
                    $errorMsg = $oProduct['name']."[".$oProduct['id']."]".": ";
                    foreach ($this->getError() as $key=>$value){
                        $errorMsg .= $value . ";";
                    }

                    throw  new ParameterException([
                        'msg' => $errorMsg,
                    ]);
                }
            }
            return true;
        }else{
            throw new ParameterException(["msg"=>"订单商品为空"]);
        }
    }


}