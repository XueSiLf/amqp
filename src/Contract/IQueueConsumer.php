<?php
/**
 * Created by PhpStorm.
 * User: XueSi <1592328848@qq.com>
 * Date: 2022/3/5
 * Time: 11:12 上午
 */
declare(strict_types=1);

namespace LavaMusic\AMQP\Contract;

interface IQueueConsumer extends IConsumer
{
    /**
     * 重新打开
     */
    public function reopen(): void;

    /**
     * 弹出消息.
     */
    public function pop(float $timeout): ?Message;
}