<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/29
 * Time: 15:54
 */

namespace app\api\controller\v1;


use app\api\model\User;
use app\api\model\UserAddress;
use app\api\service\UserTokenService;
use app\api\validate\AddressNew;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;
use think\Request;

class Address
{
    public function saveAddress()
    {
        $validate = new AddressNew();
        $validate->goCheck();

        $data = $validate->getDataByRule();
        $token = (Request::instance())->header('token');
        $uid = UserTokenService::getValueFromToken('uid',$token);

        $userExist = User::get($uid);
        if($userExist){
            $data['user_id'] = $uid;
            $res = UserAddress::save($data);
            if($res){
                throw new SuccessMessage(); // 保存成功
            }else{
                throw new UserException(['msg'=>'用户地址信息保存失败']);
            }
        }else{
            throw new UserException();
        }

    }
}