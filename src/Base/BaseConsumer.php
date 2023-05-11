<?php
/**
 * Created by PhpStorm.
 * User: XueSi <1592328848@qq.com>
 * Date: 2022/3/5
 * Time: 11:43 上午
 */
declare(strict_types=1);

namespace LavaMusic\AMQP\Base;

use LavaMusic\AMQP\Base\Traits\TAMQP;
use LavaMusic\AMQP\Connection\Config;
use LavaMusic\AMQP\Contract\IConsumer;
use LavaMusic\AMQP\Contract\IMessage;
use LavaMusic\AMQP\Enum\ConsumerResult;
use LavaMusic\AMQP\Message;

/**
 * 消费者基类.
 */
abstract class BaseConsumer implements IConsumer
{
    use TAMQP;

    public function __construct(Config $config)
    {
        $this->initConfig($config);
    }

    /**
     * {@inheritDoc}
     */
    public function run(): void
    {
        $this->connection = $this->getConnection();
        $this->channel = $this->connection->channel();

        $prefetchSize = $this->config->getPrefetchSize();
        $prefetchCount = $this->config->getPrefetchCount();
        $global = $this->config->isGlobal();
        $this->channel->basic_qos($prefetchSize, $prefetchCount, $global);

        $this->declareConsumer();
        $this->bindConsumer();

        while ($this->channel && $this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function stop(): void
    {
        if ($this->channel) {
            $this->channel->close();
            $this->channel = null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function close(): void
    {
        $this->stop();
        $this->connection = null;
    }

    /**
     * 绑定消费者.
     */
    protected function bindConsumer(): void
    {
        foreach ($this->consumers as $consumer) {
            foreach ((array)$consumer->getQueue() as $queueName) {
                $messageClass = $consumer->getMessage() ?? Message::class;
                $this->channel->basic_consume($queueName, $consumer->getTag(), false, false, false, false, function (\PhpAmqpLib\Message\AMQPMessage $message) use ($messageClass) {
                    try {
                        /** @var Message $messageInstance */
                        $messageInstance = new $messageClass();
                        $messageInstance->setAMQPMessage($message);

//                        $result = goWait(fn () => $this->consume($messageInstance));
                        $result = goWait(function () use ($messageInstance) {
                            return $this->consume($messageInstance);
                        });

                        switch ($result) {
                            case ConsumerResult::ACK:
                                $this->channel->basic_ack($message->getDeliveryTag());
                                break;
                            case ConsumerResult::NACK:
                                $this->channel->basic_nack($message->getDeliveryTag());
                                break;
                            case ConsumerResult::NACK_REQUEUE:
                                $this->channel->basic_nack($message->getDeliveryTag(), false, true);
                                break;
                            case ConsumerResult::REJECT:
                                $this->channel->basic_reject($message->getDeliveryTag(), false);
                                break;
                            case ConsumerResult::REJECT_REQUEUE:
                                $this->channel->basic_reject($message->getDeliveryTag(), true);
                                break;
                        }
                    } catch (\Throwable $th) {
                        throw $th;
                    }
                });
            }
        }
    }

    /**
     * 消费任务
     *
     * @return mixed
     */
    abstract protected function consume(IMessage $message);
}
