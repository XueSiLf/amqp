<?php
/**
 * Created by PhpStorm.
 * User: XueSi <1592328848@qq.com>
 * Date: 2022/3/5
 * Time: 11:52 上午
 */
declare(strict_types=1);

namespace LavaMusic\AMQP\Base;

use LavaMusic\AMQP\Base\Traits\TAMQP;
use LavaMusic\AMQP\Connection\Config;
use LavaMusic\AMQP\Contract\IMessage;
use LavaMusic\AMQP\Contract\IPublisher;
use PhpAmqpLib\Message\AMQPMessage;

abstract class BasePublisher implements IPublisher
{
    use TAMQP;

    /**
     * ack 是否成功
     * @var bool
     */
    private $ackSuccess;

    public function __construct(Config $config)
    {
        $this->initConfig($config);
    }

    /**
     * {@inheritDoc}
     */
    public function close(): void
    {
        if ($this->channel) {
            $this->channel->close();
            $this->channel = null;
        }
        $this->connection = null;
    }

    /**
     * 准备发布.
     */
    protected function preparePublish(bool $force = false): void
    {
        if (!$this->connection) {
            $this->connection = $this->getConnection();
        }
        if ($force || !$this->connection->isConnected()) {
            $this->connection->reconnect();
            $this->channel = null;
        }
        if (!$this->channel || !$this->channel->is_open()) {
            $this->channel = $this->connection->channel();
            $this->channel->confirm_select();
            $this->declarePublisher();
        }
        $this->ackSuccess = false;
        $this->channel->set_ack_handler(function () {
            $this->ackSuccess = true;
        });
    }

    /**
     * {@inheritDoc}
     */
    public function publish(IMessage $message): bool
    {
        $this->preparePublish();
        $amqpMessage = new AMQPMessage($message->getBody(), $message->getProperties());
        $first = true;
        $continue = true;

        foreach ($this->exchanges as $exchange) {
            do {
                try {
                    $this->channel->basic_publish($amqpMessage, $exchange->getName(), $message->getRoutingKey(), $message->getMandatory(), $message->getImmediate(), $message->getTicket());
                    $this->channel->wait_for_pending_acks_returns(3);
                    if (!$this->ackSuccess) {
                        break 2;
                    }
                    $first = false;
                    $continue = false;
                } catch (\Throwable $th) {
                    if ($first) {
                        $first = false;
                        $this->preparePublish(true);
                        continue;
                    } else {
                        throw $th;
                    }
                }
            } while ($continue);
        }

        $this->channel->set_ack_handler(static function () {
        });

        return $this->ackSuccess;
    }
}