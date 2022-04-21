<?php
/**
 * Created by PhpStorm.
 * User: XueSi <1592328848@qq.com>
 * Date: 2022/3/5
 * Time: 11:13 上午
 */
declare(strict_types=1);

namespace LavaMusic\AMQP;

use LavaMusic\AMQP\Contract\IMessage;
use LavaMusic\AMQP\Protocol\Formatter;
use LavaMusic\AMQP\Protocol\IFormatter;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * AMQP 消息.
 */
class Message implements IMessage
{
    /**
     * 主体内容.
     *
     * @var mixed
     */
    protected $bodyData;

    /**
     * 配置属性.
     * @var array
     */
    protected $properties = [
        'content_type'  => 'text/plain',
        'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
    ];

    /**
     * 路由键.
     * @var string
     */
    protected $routingKey = '';

    /**
     * mandatory标志位
     * 当mandatory标志位设置为true时，如果exchange根据自身类型和消息routeKey无法找到一个符合条件的queue，那么会调用basic.return方法将消息返还给生产者；当mandatory设为false时，出现上述情形broker会直接将消息扔掉。
     * @var bool
     */
    protected $mandatory = false;

    /**
     * immediate标志位
     * 当immediate标志位设置为true时，如果exchange在将消息route到queue(s)时发现对应的queue上没有消费者，那么这条消息不会放入队列中。当与消息routeKey关联的所有queue(一个或多个)都没有消费者时，该消息会通过basic.return方法返还给生产者。
     * @var bool
     */
    protected $immediate = false;

    /**
     * ticket.
     * @var int|null
     */
    protected $ticket = null;

    /**
     * 格式处理.
     * @var string|null
     */
    protected $format = null;

    /**
     * AMQP 消息.
     * @var AMQPMessage
     */
    protected $amqpMessage;

    public function __construct()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * {@inheritDoc}
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoutingKey(): string
    {
        return $this->routingKey;
    }

    /**
     * {@inheritDoc}
     */
    public function setRoutingKey(string $routingKey): self
    {
        $this->routingKey = $routingKey;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getMandatory(): bool
    {
        return $this->mandatory;
    }

    /**
     * {@inheritDoc}
     */
    public function setMandatory(bool $mandatory): self
    {
        $this->mandatory = $mandatory;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getImmediate(): bool
    {
        return $this->immediate;
    }

    /**
     * {@inheritDoc}
     */
    public function setImmediate(bool $immediate): self
    {
        $this->immediate = $immediate;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getTicket(): ?int
    {
        return $this->ticket;
    }

    /**
     * {@inheritDoc}
     */
    public function setTicket(?int $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setBodyData($data): self
    {
        $this->bodyData = $data;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getBodyData()
    {
        return $this->bodyData;
    }

    /**
     * {@inheritDoc}
     */
    public function getBody(): string
    {
        if (null === $this->format)
        {
            return $this->getBodyData();
        }
        else
        {
            /** @var IFormatter $formater */
            $formatter = (new Formatter($this->format))->getFormatterProtocol();
            return $formatter->encode($this->getBodyData());
        }
    }

    /**
     * {@inheritDoc}
     */
    public function setBody(string $body): self
    {
        if (null === $this->format)
        {
            $this->setBodyData($body);
        }
        else
        {
            /** @var IFormatter $formater */
            $formatter = (new Formatter($this->format))->getFormatterProtocol();
            $data = $formatter->decode($body);
            $this->setBodyData($data);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setAMQPMessage(AMQPMessage $amqpMessage): void
    {
        $this->amqpMessage = $amqpMessage;
        $this->setBody($amqpMessage->getBody());
    }

    /**
     * {@inheritDoc}
     */
    public function getAMQPMessage(): ?AMQPMessage
    {
        return $this->amqpMessage;
    }
}