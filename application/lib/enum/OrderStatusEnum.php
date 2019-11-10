<?php


namespace app\lib\enum;


class OrderStatusEnum
{
    // 尚未支付
    const NOT_PAY = 1;
    // 已支付
    const PAYED = 2;
    // 已经发货
    const DELIVED = 3;
    // 已经支付 但是库存不足
    const PAYED_HAVE_NOT_STOCK = 4;
}