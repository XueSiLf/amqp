<?php
/**
 * Created by PhpStorm.
 * Author: hlh XueSi
 * Email: 1592328848@qq.com
 * Date: 2022/4/21 14:40:40
 */
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

class Producer extends \LavaMusic\AMQP\Base\BasePublisher
{

}

go (function () {
    $config = new \LavaMusic\AMQP\Connection\Config([
        'host' => '127.0.0.1',
        'port' => 5672,
        'user' => 'guest',
        'password' => 'guest',
        'vhost' => '/',
    ]);

    $exchangeConfig = new \LavaMusic\AMQP\Config\ExchangeConfig([
        'name' => 'router',
    ]);

    $queueConfig = new \LavaMusic\AMQP\Config\QueueConfig([
        'name' => 'msgs'
    ]);

    $publisher = new Producer($config);
    $publisher->addExchange($exchangeConfig);
    $publisher->addQueue($queueConfig);

    $message = new \LavaMusic\AMQP\Message();

    $data = json_encode(['name' => 'xuesi' . date('Y-m-d H:i:s')]);

    $message->setBody($data);

    $isPublished = $publisher->publish($message);

    if ($isPublished) {
        var_dump('发布成功');
    } else {
        var_dump('发布失败');
    }

    $publisher->close();
});

