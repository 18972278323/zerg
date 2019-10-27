<?php


namespace app\api\validate;

use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
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
}