<?php
/**
 * Created by PhpStorm.
 * User: XueSi <1592328848@qq.com>
 * Date: 2022/3/5
 * Time: 11:19 上午
 */
declare(strict_types=1);

namespace LavaMusic\AMQP\Protocol;

class Formatter
{
    /**
     * @var string $formatter
     */
    protected $formatter;

    /**
     * @var IFormatter $formatterProtocol
     */
    protected $formatterProtocol;

    public function __construct(string $formatter)
    {
        $this->formatter = $formatter;

        $class = '\\LavaMusic\\AMQP\\Protocol\\' . ucfirst($formatter);
        if (class_exists($class)) {
            $this->formatterProtocol = new $class();
        }
    }

    public function getFormatterProtocol(): ?IFormatter
    {
        return $this->formatterProtocol;
    }

    public function getFormatter(): ?string
    {
        return $this->formatter;
    }
}