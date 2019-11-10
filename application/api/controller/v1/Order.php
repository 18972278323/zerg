<?php


namespace app\api\controller\v1;


use app\api\service\OrderService;
use app\api\validate\OrderValidate;
use think\Exception;
use think\Request;

class Order extends BaseController
{
    /**
     * @url /api/v1/order/add
     * @header token
     * @param 请求参数格式 {"products":[ {"id":1,"count":1,"name":"苹果"},"addressId":35}
     * @throws Exception
     */
    public function createOrder()
    {
        $this->checkOnlyUserScope();
        (new OrderValidate())->goCheck();

        $request = Request::instance();
        $oProducts = $request->post("products/a");
        $addressID = $request->post("addressId");

        $res = (new OrderService($oProducts,$addressID))->createOrder();
        dump($res);
    }
}