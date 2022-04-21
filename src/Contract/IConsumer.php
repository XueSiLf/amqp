<?php
/**
 * Created by PhpStorm.
 * User: XueSi <1592328848@qq.com>
 * Date: 2022/3/5
 * Time: 11:11 上午
 */
declare(strict_types=1);

namespace LavaMusic\AMQP\Contract;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AbstractConnection;

/**
 * 消费者.
 */
interface IConsumer
{
    /**
     * 运行消费循环.
     */
    public function run(): void;

    /**
     * 停止消费循环.
     */
    public function stop(): void;

    /**
     * 关闭.
     */
    public function close(): void;

    /**
     * Get 连接.
     */
    public function getAMQPConnection(): AbstractConnection;

    /**
     * Get 频道.
     */
    public function getAMQPChannel(): AMQPChannel;
}