<?php


namespace app\api\service;


use app\api\controller\v1\Order;
use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\UserAddress;
use app\api\model\Order as OrderModel;
use app\lib\enum\OrderStatusEnum;
use app\lib\exception\AddressException;
use app\lib\exception\OrderException;
use app\lib\exception\ParameterException;
use think\Db;


class OrderService extends BaseService
{
    // 请求中的商品信息
    protected $oProducts;
    // 库存中的商品信息
    protected $products;
    // 用户ID
    protected $uid;
    // 订单地址ID
    protected $addressId;

    public function __construct($oProducts = [], $addressId)
    {
        if (!$oProducts) {
            throw new ParameterException(["msg" => "订单商品参数为空"]);
        }
        $this->oProducts = $oProducts;
        $this->products = $this->getProducts($oProducts);
        $this->uid = UserTokenService::getValueFromToken('uid');
        $this->addressId = $addressId;
    }

    // 创建订单
    public function createOrder()
    {
        Db::startTrans();
        try {
            // 检查订单状态 校验库存
            $orderStatus = $this->getOrderStatus();

            // 库存检测失败
            if (!$orderStatus['pass']) {
                $orderStatus["order_id"] = -1; // 表示订单创建失败
                return $orderStatus;
            }

            // 库存检测通过 创建订单快照(订单详情)
            $orderSnap = $this->getOrderSnap($orderStatus);

            // 生成订单编号 获取用户ID
            $orderNum = $this->genOrderNum();
            $uid = UserTokenService::getValueFromToken('uid');
            $orderSnap['order_no'] = $orderNum;
            $orderSnap['user_id'] = $uid;
            $orderSnap['status'] = OrderStatusEnum::NOT_PAY;

            // 保存快照信息
            $order = OrderModel::create($orderSnap);
            // 保存订单商品对应信息
            $orderId = $order->id;
            $orderProduct = [];
            foreach ($this->oProducts as $oProduct) {
                $orderProduct[] = [
                    'product_id' => $oProduct['id'],
                    'order_id' => $orderId,
                    'count' => $oProduct['count'],
                ];
            }
            (new OrderProduct())->saveAll($orderProduct);

            Db::commit();
            // 返回结果
            return [
                'order_no' => $order->order_no,
                'order_id' => $order->id,
                'create_time' => $order->create_time,
            ];

        } catch (Exception $ex) {
            Db::rollback();
            throw $ex;
        }
    }

    // 生成订单编号
    private function genOrderNum()
    {
        $yCode = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M'];
        $res = $yCode[intval(date('Y') - 2019)] . strtoupper(dechex(date('m'))) . date('d')
            . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $res;
    }


    // 创建订单快照
    private function getOrderSnap($orderStatus)
    {
        $snap = [
            'total_price' => 0,
            'snap_img' => '',
            'snap_name' => '',
            'total_count' => 0,
            'snap_items' => '', // 订单详情
            'snap_address' => '',
        ];

        $snap['total_price'] = $orderStatus['totalPrice'];
        $snap['snap_img'] = $this->products[0]['main_img_url'];
        $snap['snap_name'] = $this->products[0]['name'];
        $snap['total_count'] = $orderStatus['totalCount'];
        $snap['snap_items'] = json_encode($orderStatus['pStatusArray']);
        $snap['snap_address'] = $this->getOrderAddress();
        if (count($this->oProducts) > 1) {
            $snap['snap_name'] .= " 等商品";
        }
        return $snap;
    }

    // 获取地址信息
    private function getOrderAddress()
    {
        $uid = UserTokenService::getValueFromToken('uid');
        $res = UserAddress::where('user_id', '=', $uid)->find($this->addressId);
        if (!$res) {
            throw new AddressException([
                'msg' => '用户地址获取失败',
                'errorCode' => '71001',
            ]);
        }
        $address = $res['province'] . $res['city'] . $res['country'] . $res['detail'] . "【" . $res['mobile'] . "】";
        return $address;
    }

    /**
     * 获取订单状态
     * @throws OrderException
     */
    private function getOrderStatus()
    {
        // 返回值
        $oStatus = [
            'pass' => true,     // 订单库存检测是否通过
            'totalCount' => 0,     // 订单总商品数
            'totalPrice' => 0,        // 订单总价格
            'pStatusArray' => [],       // 商品状态数组
        ];
        // 获取每条商品的状态
        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStatus($oProduct['id'], $oProduct['count'], $oProduct['name'], $this->products);

            // 订单状态处理
            if (!$pStatus['hasStock']) {
                $oStatus['pass'] = false;
            }
            $oStatus['totalPrice'] += $pStatus['totalPrice'];
            $oStatus['totalCount'] += $pStatus['count'];
            array_push($oStatus['pStatusArray'], $pStatus);
        }
        return $oStatus;
    }

    // 获取商品状态
    private function getProductStatus($id, $count, $name, $products)
    {

        // 需要返回的商品状态
        $pStatus = [
            'id' => null,
            'count' => 0,
            'hasStock' => false,
            'name' => '',
            'price' => 0,
            'totalPrice' => 0,
        ];

        // 商品索引
        $index = -1;
        for ($i = 0; $i < count($products); $i++) {
            if ($id == $products[$i]['id']) {
                $index = $i;
            }
        }

        // 未找到商品抛出异常
        if ($index == -1) {
            throw new OrderException(['msg' => "$name[$id] 商品状态异常，请重试"]);
        }

        // 找到商品 获取商品状态
        $product = $products[$index];
        $pStatus['id'] = $product['id'];
        $pStatus['count'] = $count;
        $pStatus['name'] = $product['name'];
        $pStatus['price'] = $product['price'];
        $pStatus['totalPrice'] = $product['price'] * $count;
        if ($count <= $product['stock']) {
            $pStatus['hasStock'] = true;
        }

        return $pStatus;
    }


    // 获取订单中商品在数据库中的详情
    private function getProducts($oProducts)
    {
        $ids = [];
        foreach ($oProducts as $oProduct) {
            array_push($ids, $oProduct['id']);
        }
        if (count($ids) <= 0) {
            throw new ParameterException(["msg" => "订单商品参数为空"]);
        }

        $products = Product::all($ids);
        return $products->toArray();
    }


}