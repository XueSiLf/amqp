<?php
/**
 * Created by PhpStorm.
 * User: XueSi <1592328848@qq.com>
 * Date: 2022/3/5
 * Time: 11:17 上午
 */
declare(strict_types=1);

namespace LavaMusic\AMQP\Protocol;

interface IFormatter
{
    /**
     * 编码为存储格式.
     *
     * @param mixed $data
     */
    public function encode($data): string;

    /**
     * 解码为php变量.
     *
     * @return mixed
     */
    public function decode(string $data);
}