<?php


namespace app\api\service;


use think\Config;
use think\Exception;

class UserTokenService
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    // 拼接请求 openid的 url地址
    public function __construct($code='')
    {
        $this->code = $code;
        $this->wxAppID = Config::get('wx.wx_app_code');
        $this->wxAppSecret = Config::get('wx.wx_app_secret');
        $this->wxLoginUrl = sprintf(Config::get('wx.wx_opid_url'), $this->wxAppID, $this->wxAppSecret,$this->code);
    }


    // 获取 openID
    public function get()
    {
        $res = curl_get($this->wxLoginUrl);
        $wxRes = json_decode($res,true);

        if(empty($wxRes)){
            throw new Exception('获取openid发生异常');
        }else{
            if(array_key_exists('errcode',$wxRes)){
                // 调用失败


            }else{
                // 调用成功

            }
        }

    }
}