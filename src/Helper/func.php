<?php
/**
 * Created by PhpStorm.
 * User: XueSi <1592328848@qq.com>
 * Date: 2022/3/5
 * Time: 11:08 下午
 */
declare(strict_types=1);

use Swoole\Coroutine;
use Swoole\Coroutine\Channel;

if (!function_exists('goWait')) {
    /**
     * 创建一个协程A，挂起当前协程等待A协程执行完毕，并返回A协程的返回值
     *
     * @param callable   $callable 任务回调列表
     * @param float|null $timeout  超时时间，为 -1 则不限时
     */
    function goWait(callable $callable, ?float $timeout = -1): ?array
    {
        $taskCallables = [$callable];
        $channel = new Channel(1);
        $taskCount = \count($taskCallables);
        $count = 0;
        $results = [];

        foreach ($taskCallables as $key => $callable) {
            $results[$key] = null;
            Coroutine::create(function () use ($key, $callable, $channel) {
                $channel->push([
                    'key' => $key,
                    'result' => $callable(),
                ]);
            });
        }

        $leftTimeout = (-1.0 === $timeout ? null : $timeout);
        while ($count < $taskCount) {
            $beginTime = microtime(true);
            $result = $channel->pop(null === $leftTimeout ? -1 : $leftTimeout);
            $endTime = microtime(true);
            if (false === $result) {
                break; // 超时
            }
            if (null !== $leftTimeout) {
                $leftTimeout -= ($endTime - $beginTime);
                if ($leftTimeout <= 0) {
                    break; // 剩余超时时间不足
                }
            }
            ++$count;
            $results[$result['key']] = $result['result'];
        }

        return $results[0] ?? null;
    }
}