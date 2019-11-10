<?php


namespace app\api\controller\v1;


use app\api\service\UserTokenService;
use app\api\validate\TokenValidate;

class Token
{
    /**
     * 根据Code码获取令牌
     * @url token/user?code=111111
     * @param string $code
     * @throws
     * @return array token令牌
     */
    public function getToken($code ='')
    {
        (new TokenValidate())->goCheck();

        $tokenService = new UserTokenService($code);
        $token =  $tokenService->getToken();
        return ['token'=>$token];
    }
}