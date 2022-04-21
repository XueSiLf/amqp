<?php
/**
 * Created by PhpStorm.
 * User: XueSi <1592328848@qq.com>
 * Date: 2022/3/5
 * Time: 11:11 上午
 */
declare(strict_types=1);

namespace LavaMusic\AMQP\Contract;

/**
 * 发布者.
 */
interface IPublisher
{
    /**
     * 发布消息.
     */
    public function publish(IMessage $message): bool;
}