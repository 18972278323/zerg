<?php


namespace app\api\validate;

use app\api\model\UserAddress;
use app\api\service\UserTokenService;
use app\lib\exception\AddressException;
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

    // 验证地址ID是否存在
    public function checkAddressId($value)
    {
        $uid = UserTokenService::getValueFromToken('uid');
        $res = UserAddress::where('user_id','=',$uid)->find($value);
        if(!$res){
            throw new AddressException([
                'msg' => "地址信息查询失败",
                'errorCode' => 71001,
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

    // 通过获得验证规则中验证过的参数
    public function getDataByRule()
    {
        $data = (Request::instance())->post();
        if(array_key_exists('user_id',$data)){
            throw new ParameterException(['msg'=>'数据中含有非法参数']);
        }else{
            $dataNew = [];
            foreach ($this->rule as $key => $value){
                $dataNew[$key] = $data[$key];
            }
            return $dataNew;
        }
    }
}