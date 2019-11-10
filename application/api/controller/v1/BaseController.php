<?php


namespace app\api\controller\v1;


use app\api\service\UserTokenService;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Controller;

class BaseController extends Controller
{
    // 检查至少有用户用户权限
    public function checkLeastUserScope()
    {
        $scope = UserTokenService::getValueFromToken('scope');
        if($scope){
            if ($scope < ScopeEnum::USER) {
                throw new ForbiddenException();
            }else{
                return true;
            }
        }else{
            throw new TokenException();
        }

    }

    // 检查仅仅允许用户权限
    public function checkOnlyUserScope()
    {
        $scope = UserTokenService::getValueFromToken('scope');
        if($scope){
            if ($scope != ScopeEnum::USER) {
                throw new ForbiddenException();
            }else{
                return true;
            }
        }else{
            throw new TokenException();
        }

    }

    // 检查超级管理员权限
    public function checkOnlySuperScope()
    {
        $scope = UserTokenService::getValueFromToken('scope');
        if($scope){
            if ($scope < ScopeEnum::SUPER) {
                throw new ForbiddenException();
            }else{
                return true;
            }
        }else{
            throw new TokenException();
        }
    }
}