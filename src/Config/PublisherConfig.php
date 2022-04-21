<?php
/**
 * Created by PhpStorm.
 * User: XueSi <1592328848@qq.com>
 * Date: 2022/3/5
 * Time: 10:38 下午
 */
declare(strict_types=1);

namespace LavaMusic\AMQP\Config;

use EasySwoole\Spl\SplBean;

class PublisherConfig extends SplBean
{
    /**
     *  * @property string|array      $queue      队列名称
     * @property string|array|null $exchange   交换机名称
     * @property string            $routingKey 路由键
     */
    /**
     * 队列名称
     * @var string
     */
    protected $queue = '';

    /**
     * 交换机名称
     * @var string|null
     */
    protected $exchange = null;

    /**
     * 路由键
     * @var string
     */
    protected $routingKey = '';

    /**
     * @return string
     */
    public function getQueue(): string
    {
        return $this->queue;
    }

    /**
     * @param string $queue
     */
    public function setQueue(string $queue): void
    {
        $this->queue = $queue;
    }

    /**
     * @return string|null
     */
    public function getExchange(): ?string
    {
        return $this->exchange;
    }

    /**
     * @param string|null $exchange
     */
    public function setExchange(?string $exchange): void
    {
        $this->exchange = $exchange;
    }

    /**
     * @return string
     */
    public function getRoutingKey(): string
    {
        return $this->routingKey;
    }

    /**
     * @param string $routingKey
     */
    public function setRoutingKey(string $routingKey): void
    {
        $this->routingKey = $routingKey;
    }
}