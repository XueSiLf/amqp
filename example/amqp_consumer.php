<?php
/**
 * Created by PhpStorm.
 * Author: hlh XueSi
 * Email: 1592328848@qq.com
 * Date: 2022/4/21 14:47:25
 */
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

class Consumer extends \LavaMusic\AMQP\Base\BaseConsumer
{
    protected function consume(\LavaMusic\AMQP\Contract\IMessage $message)
    {
        echo PHP_EOL . PHP_EOL;
        echo '消费时间: ' . date('Y-m-d H:i:s') . PHP_EOL;
        echo '队列消息体如下: ' . $message->getBody() . PHP_EOL;

        // 响应ACK
        return \LavaMusic\AMQP\Enum\ConsumerResult::ACK;
    }
}

go(function () {
    $config = new \LavaMusic\AMQP\Connection\Config([
        'host' => '127.0.0.1',
        'port' => 5672,
        'user' => 'guest',
        'password' => 'guest',
        'vhost' => '/',
        'connectionTimeout' => 10.0
    ]);

    $exchangeConfig = new \LavaMusic\AMQP\Config\ExchangeConfig([
        'name' => 'router',
    ]);

    $queueConfig = new \LavaMusic\AMQP\Config\QueueConfig([
        'name' => 'msgs'
    ]);

    $exchange = 'router';
    $queue = 'msgs';
    $consumerTag = 'consumer';

    $consumerConfig = new \LavaMusic\AMQP\Config\ConsumerConfig();
    $consumerConfig->setTag($consumerTag);
    $consumerConfig->setQueue($queue);
    $consumerConfig->setExchange($exchange);

    $consumer = new Consumer($config);

    $consumer->addExchange($exchangeConfig);
    $consumer->addQueue($queueConfig);
    $consumer->addConsumer($consumerConfig);

    $consumer->run();
});