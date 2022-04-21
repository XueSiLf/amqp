<?php
/**
 * Created by PhpStorm.
 * User: XueSi <1592328848@qq.com>
 * Date: 2022/3/5
 * Time: 10:42 下午
 */
declare(strict_types=1);

namespace LavaMusic\AMQP\Config;

use EasySwoole\Spl\SplBean;
use LavaMusic\AMQP\Message;

class ConsumerConfig extends SplBean
{
    /**
     * 消费者标签
     * @var string
     */
    protected $tag = '';

    /**
     * 队列名称
     * @var string
     */
    protected $queue = '';

    /**
     * 交换机名称
     * @var null|string
     */
    protected $exchange = null;

    /**
     * 路由键
     * @var string
     */
    protected $routingKey = '';

    /**
     * 消息类名
     * @var string
     */
    protected $message = Message::class;

    /**
     * mandatory标志位；当mandatory标志位设置为true时，
     * 如果exchange根据自身类型和消息routeKey无法找到一个符合条件的queue，
     * 那么会调用basic.return方法将消息返还给生产者；
     * 当mandatory设为false时，出现上述情形broker会直接将消息扔掉。
     * @var bool
     */
    protected $mandatory = false;

    /**
     * immediate标志位；
     *
     * 当immediate标志位设置为true时，如果exchange在将消息route到queue(s)时发现对应的queue上没有消费者，那么这条消息不会放入队列中。当与消息routeKey关联的所有queue(一个或多个)都没有消费者时，该消息会通过basic.return方法返还给生产者。
     * @var bool
     */
    protected $immediate = false;

    /**
     * @var int|null
     */
    protected $ticket = null;

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     */
    public function setTag(string $tag): void
    {
        $this->tag = $tag;
    }

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

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function isMandatory(): bool
    {
        return $this->mandatory;
    }

    /**
     * @param bool $mandatory
     */
    public function setMandatory(bool $mandatory): void
    {
        $this->mandatory = $mandatory;
    }

    /**
     * @return bool
     */
    public function isImmediate(): bool
    {
        return $this->immediate;
    }

    /**
     * @param bool $immediate
     */
    public function setImmediate(bool $immediate): void
    {
        $this->immediate = $immediate;
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