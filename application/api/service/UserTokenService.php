<?php


namespace app\api\service;


use app\api\model\User;
use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Cache;
use think\Config;
use think\Exception;
use think\Request;

class UserTokenService extends BaseService
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    // 拼接请求 openid的 url地址
    public function __construct($code='')
    {
        $this->code = $code;
        $this->wxAppID = Config::get('wx.wx_app_id');
        $this->wxAppSecret = Config::get('wx.wx_app_secret');
        $this->wxLoginUrl = sprintf(Config::get('wx.wx_opid_url'),
            $this->wxAppID, $this->wxAppSecret,$this->code);
    }

    // 从Token中获取指定字段的值
    public static function  getValueFromToken($name)
    {
        $token = Request::instance()->header('token');
        if(!$token){
            throw new TokenException();
        }
        $userInfo = Cache::get($token);
        if(!$userInfo){
            throw new TokenException();
        }else{
            if(!is_array($userInfo)){
                $userInfo = json_decode($userInfo,true);
            }

            if(array_key_exists($name,$userInfo)){
                return $userInfo[$name];
            }else{
                throw new Exception('传入未知字段名');
            }
        }
    }


    // 生成Token
    public function getToken()
    {
        $res = curl_get($this->wxLoginUrl);
        $wxRes = json_decode($res,true);

        if(empty($wxRes)){
            throw new Exception('获取openid发生异常');
        }else{
            if(!array_key_exists('errcode',$wxRes)){
                // 获取失败
                throw new Exception('获取openid发生异常');
            }else{
                if(true){ // 获取成功
//                if($wxRes['errcode'] == 0){ // 获取成功，生成Token，存储缓存
                    $key = $this->genToken();
                    $cacheValue = $this->getCacheValue($wxRes);
                    $expire = Config::get('setting.token_expire_in');
                    $res = Cache::set($key,$cacheValue,$expire);

                    if(!$res){
                        throw new Exception("服务器缓存异常");
                    }
                    return $key;
                }else{  // 获取失败
                    throw new WeChatException([
                        'httpCode'=> 400,
                        'msg'    => $wxRes['errmsg'],
                        'errorCode'  =>$wxRes['errcode'],
                    ]);
                }
            }
        }

    }


    /**
     * @return string
     */
    private function getCacheValue($wxRes)
    {
//        $openId = $wxRes['openid'];
        $openId = 1;
        $wxRes['uid'] = $this->getIDByOpenID($openId);
        $wxRes['scope'] = ScopeEnum::USER;
//        $wxRes['scope'] = 15;

        return json_encode($wxRes);
    }

    /**
     * @param $openId 微信返回的OpenID
     * @return int $id 用户在数据库中的ID
     * @throws
     */
    private function getIDByOpenID($openId)
    {
        $userExist = User::where('openid', '=', $openId)->find();
        if(!$userExist){
            $userAdd = User::create(['openid'=>$openId]);
            $id = $userAdd->id;
        }else{
            $id = $userExist->id;
        }
        return $id;
    }


}