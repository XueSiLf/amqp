<?php
/**
 * Created by PhpStorm.
 * User: XueSi <1592328848@qq.com>
 * Date: 2022/3/5
 * Time: 4:00 下午
 */
declare(strict_types=1);

namespace LavaMusic\AMQP\Config;

use EasySwoole\Spl\SplBean;

class QueueConfig extends SplBean
{
    /**
     * 队列名称
     * @var string
     */
    protected $name = '';

    /**
     * 路由键
     * @var string
     */
    protected $routingKey = '';

    /**
     * 被动模式
     * @var bool
     */
    protected $passive = false;

    /**
     * 消息队列持久化
     * @var bool
     */
    protected $durable = true;

    /**
     * 独占；如果是true，那么申明这个queue的connection断了，
     * 那么这个队列就被删除了，包括里面的消息。
     * @var bool
     */
    protected $exclusive = false;

    /**
     * 自动删除
     * @var bool
     */
    protected $autoDelete = false;

    /**
     * 是否非阻塞；true表示是。
     * 阻塞：表示创建交换器的请求发送后，阻塞等待RMQ Server返回信息。
     * 非阻塞：不会阻塞等待RMQ
     * @var bool
     */
    protected $nowait = false;

    /**
     * 参数
     * @var array|\PhpAmqpLib\Wire\AMQPTable $arguments
     */
    protected $arguments = [];

    /**
     * 参数
     * @var int|null
     */
    protected $ticket = null;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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

    /**
     * @return bool
     */
    public function isPassive(): bool
    {
        return $this->passive;
    }

    /**
     * @param bool $passive
     */
    public function setPassive(bool $passive): void
    {
        $this->passive = $passive;
    }

    /**
     * @return bool
     */
    public function isDurable(): bool
    {
        return $this->durable;
    }

    /**
     * @param bool $durable
     */
    public function setDurable(bool $durable): void
    {
        $this->durable = $durable;
    }

    /**
     * @return bool
     */
    public function isExclusive(): bool
    {
        return $this->exclusive;
    }

    /**
     * @param bool $exclusive
     */
    public function setExclusive(bool $exclusive): void
    {
        $this->exclusive = $exclusive;
    }

    /**
     * @return bool
     */
    public function isAutoDelete(): bool
    {
        return $this->autoDelete;
    }

    /**
     * @param bool $autoDelete
     */
    public function setAutoDelete(bool $autoDelete): void
    {
        $this->autoDelete = $autoDelete;
    }

    /**
     * @return bool
     */
    public function isNowait(): bool
    {
        return $this->nowait;
    }

    /**
     * @param bool $nowait
     */
    public function setNowait(bool $nowait): void
    {
        $this->nowait = $nowait;
    }

    /**
     * @return array|\PhpAmqpLib\Wire\AMQPTable
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param array|\PhpAmqpLib\Wire\AMQPTable $arguments
     */
    public function setArguments($arguments): void
    {
        $this->arguments = $arguments;
    }

    /**
     * @return int|null
     */
    public function getTicket(): ?int
    {
        return $this->ticket;
    }

    /**
     * @param int|null $ticket
     */
    public function setTicket(?int $ticket): void
    {
        $this->ticket = $ticket;
    }
}