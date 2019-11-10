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

class Address extends BaseController
{
    // 保存收件人地址
    public function saveAddress()
    {
        $this->checkLeastUserScope();

        $validate = new AddressNew();
        $request = Request::instance();
        $validate->goCheck();

        $data = $validate->getDataByRule();
        $uid = UserTokenService::getValueFromToken('uid');
        $addrId = $request->post('id');

        $userExist = User::get($uid);
        if($userExist){
            if(!$addrId){ // 不存在id,新增地址
                $data['user_id'] = $uid;
                $res = UserAddress::create($data);
                if($res){
                    throw new SuccessMessage(); // 保存成功
                }else{
                    throw new UserException(['msg'=>'用户地址信息保存失败']);
                }
            }else{ // 存在id, 更新地址
                $res = UserAddress::update($data,['id'=>$addrId,'user_id'=>$uid]);
                if($res){
                    throw new SuccessMessage(); // 保存成功
                }else{
                    throw new UserException(['msg'=>'用户地址信息保存失败']);
                }
            }
        }else{
            throw new UserException();
        }
    }
}