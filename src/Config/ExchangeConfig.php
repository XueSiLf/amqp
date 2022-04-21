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

class ExchangeConfig extends SplBean
{
    /**
     * 交换机名称
     * @var string
     */
    protected $name = '';

    /**
     * 类型；\PhpAmqpLib\Exchange\AMQPExchangeType::常量
     * @var string
     */
    protected $type = \PhpAmqpLib\Exchange\AMQPExchangeType::DIRECT;

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
     * 自动删除
     * @var bool
     */
    protected $autoDelete = false;

    /**
     * 设置是否为rabbitmq内部使用, true表示是内部使用, false表示不是内部使用
     * @var bool
     */
    protected $internal = false;

    /**
     * 是否非阻塞；true表示是。阻塞：表示创建交换器的请求发送后，阻塞等待RMQ Server返回信息。非阻塞：不会阻塞等待RMQ
     * @var bool
     */
    protected $nowait = false;

    /**
     * 参数
     * @var array
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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
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
    public function isInternal(): bool
    {
        return $this->internal;
    }

    /**
     * @param bool $internal
     */
    public function setInternal(bool $internal): void
    {
        $this->internal = $internal;
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
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     */
    public function setArguments(array $arguments): void
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