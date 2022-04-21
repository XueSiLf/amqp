<?php
/**
 * Created by PhpStorm.
 * User: XueSi <1592328848@qq.com>
 * Date: 2022/3/5
 * Time: 11:35 上午
 */
declare(strict_types=1);

namespace LavaMusic\AMQP\Base\Traits;

use LavaMusic\AMQP\Config\ConsumerConfig;
use LavaMusic\AMQP\Config\ExchangeConfig;
use LavaMusic\AMQP\Config\PublisherConfig;
use LavaMusic\AMQP\Config\QueueConfig;
use LavaMusic\AMQP\Connection\Config;
use LavaMusic\AMQP\Swoole\AMQPSwooleConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Wire\AMQPTable;

trait TAMQP
{
    /**
     * 连接.
     * @var AbstractConnection|null
     */
    protected $connection = null;

    /**
     * 频道.
     * @var AMQPChannel|null
     */
    protected $channel = null;

    /**
     * 队列配置列表.
     * @var QueueConfig[]
     */
    protected $queues = [];

    /**
     * 交换机配置列表.
     * @var ExchangeConfig[]
     */
    protected $exchanges = [];

    /**
     * 发布者列表.
     *
     * @var PublisherConfig[]
     */
    protected $publishers = [];

    /**
     * 消费者列表.
     *
     * @var ConsumerConfig[]
     */
    protected $consumers = [];

    /**
     * 连接配置.
     * @var Config
     */
    protected $config;

    /**
     * 调试模式
     * @var bool
     */
    protected $isDebug = false;

    public function setIsDebug(bool $isDebug)
    {
        $this->isDebug = $isDebug;
    }

    public function isDebug(): bool
    {
        return $this->isDebug;
    }

    /**
     * 初始化连接配置.
     */
    protected function initConfig(Config $config): void
    {
        $this->config = $config;
    }

    /**
     * 添加队列
     * @param QueueConfig $queue
     */
    public function addQueue(QueueConfig $queue): void
    {
        $this->queues[] = $queue;
    }

    /**
     * 添加交换机
     * @param ExchangeConfig $exchange
     */
    public function addExchange(ExchangeConfig $exchange)
    {
        $this->exchanges[] = $exchange;
    }

    public function addPublisher(PublisherConfig $publisher)
    {
        $this->publishers[] = $publisher;
    }

    public function addConsumer(ConsumerConfig $consumer)
    {
        $this->consumers[] = $consumer;
    }

    /**
     * 获取连接对象
     */
    protected function getConnection(): AbstractConnection
    {
        return new AMQPSwooleConnection(
            $this->config->getHost(),
            $this->config->getPort(),
            $this->config->getUser(),
            $this->config->getPassword(),
            $this->config->getVhost(),
            $this->config->isInsist(),
            $this->config->getLoginMethod(),
            $this->config->getLoginResponse(),
            $this->config->getLocale(),
            $this->config->getConnectionTimeout(),
            $this->config->getReadWriteTimeout(),
            $this->config->getContext(),
            $this->config->getKeepalive(),
            $this->config->getHeartbeat(),
            $this->config->getChannelRpcTimeout()
        );
    }

    /**
     * 定义.
     */
    protected function declare(): void
    {
        foreach ($this->exchanges as $exchange) {

            if ($this->isDebug()) {
                echo sprintf('exchangeDeclare: %s, type: %s', $exchange->getName(), $exchange->getType()) . PHP_EOL;
            }

            // @phpstan-ignore-next-line
            $this->channel->exchange_declare($exchange->getName(), $exchange->getType(), $exchange->isPassive(), $exchange->isDurable(), $exchange->isAutoDelete(), $exchange->isInternal(), $exchange->isNowait(), new AMQPTable($exchange->getArguments()), $exchange->getTicket());
        }

        foreach ($this->queues as $queue) {

            if ($this->isDebug()) {
                echo sprintf('queueDeclare: %s', $queue->getName()) . PHP_EOL;
            }

            $this->channel->queue_declare($queue->getName(), $queue->isPassive(), $queue->isDurable(), $queue->isExclusive(), $queue->isAutoDelete(), $queue->isNowait(), new AMQPTable($queue->getArguments()), $queue->getTicket());
        }
    }

    /**
     * 定义发布者.
     */
    protected function declarePublisher(): void
    {
        $this->declare();
        foreach ($this->publishers as $publisher) {
            foreach ((array)$publisher->getQueue() as $queueName) {
                if ('' === $queueName) {
                    continue;
                }

                foreach ((array)$publisher->getExchange() as $exchangeName) {

                    if ($this->isDebug()) {
                        echo sprintf('queueBind: %s, exchangeName: %s, routingKey: %s', $queueName, $exchangeName, $publisher->getRoutingKey()) . PHP_EOL;
                    }

                    $this->channel->queue_bind($queueName, $exchangeName, $publisher->getRoutingKey());
                }
            }
        }
    }

    /**
     * 定义消费者.
     */
    protected function declareConsumer(): void
    {
        $this->declare();

        foreach ($this->consumers as $consumer) {
            foreach ((array)$consumer->getQueue() as $queueName) {
                foreach ((array)$consumer->getExchange() as $exchangeName) {

                    echo sprintf('queueBind: %s, exchangeName: %s, routingKey: %s', $queueName, $exchangeName, $consumer->getRoutingKey()) . PHP_EOL;

                    $this->channel->queue_bind($queueName, $exchangeName, $consumer->getRoutingKey());
                }
            }
        }
    }

    /**
     * Get 连接.
     */
    public function getAMQPConnection(): AbstractConnection
    {
        if (!$this->connection) {
            $this->connection = $this->getConnection();
        }

        return $this->connection;
    }

    /**
     * Get 频道.
     */
    public function getAMQPChannel(): AMQPChannel
    {
        if (!$this->channel || !$this->channel->is_open()) {
            $this->channel = $this->getAMQPConnection()->channel();
        }

        return $this->channel;
    }
}