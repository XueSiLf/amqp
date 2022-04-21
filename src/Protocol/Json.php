<?php
/**
 * Created by PhpStorm.
 * User: XueSi <1592328848@qq.com>
 * Date: 2022/3/5
 * Time: 11:18 上午
 */
declare(strict_types=1);

namespace LavaMusic\AMQP\Protocol;

class Json implements IFormatter
{
    /**
     * {@inheritDoc}
     */
    public function encode($data): string
    {
        return json_encode($data, \JSON_THROW_ON_ERROR | \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE);
    }

    /**
     * {@inheritDoc}
     */
    public function decode(string $data)
    {
        return json_decode($data, true, 512, \JSON_THROW_ON_ERROR);
    }
}