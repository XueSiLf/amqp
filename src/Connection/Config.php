<?php
/**
 * Created by PhpStorm.
 * User: XueSi <1592328848@qq.com>
 * Date: 2022/3/5
 * Time: 12:01 下午
 */
declare(strict_types=1);

namespace LavaMusic\AMQP\Connection;

use EasySwoole\Spl\SplBean;

/**
 * Class Config
 * @author: XueSi <1592328848@qq.com>
 * @date: 2022/3/5 12:07 下午
 * @package LavaMusic\AMQP\Connection
 */
class Config extends SplBean
{
    /** @var string */
    protected $host = '';

    /** @var int */
    protected $port = 0;

    /** @var string */
    protected $user = '';

    /** @var string */
    protected $password = '';

    /** @var string */
    protected $vhost = '/';

    /** @var bool */
    protected $insist = false;

    /** @var string */
    protected $loginMethod = 'AMQPLAIN';

    /** @var null */
    protected $loginResponse = null;

    /** @var string */
    protected $locale = 'en_US';

    /** @var float */
    protected $connectionTimeout = 3.0;

    /** @var float */
    protected $readWriteTimeout = 3.0;

    /** @var null */
    protected $context = null;

    /** @var null */
    protected $keepalive = false;

    /** @var int */
    protected $heartbeat = 0;

    /** @var float */
    protected $channelRpcTimeout = 0.0;

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getVhost()
    {
        return $this->vhost;
    }

    /**
     * @param string $vhost
     */
    public function setVhost($vhost)
    {
        $this->vhost = $vhost;
    }

    /**
     * @return bool
     */
    public function isInsist()
    {
        return $this->insist;
    }

    /**
     * @param bool $insist
     */
    public function setInsist($insist)
    {
        $this->insist = $insist;
    }

    /**
     * @return string
     */
    public function getLoginMethod()
    {
        return $this->loginMethod;
    }

    /**
     * @param string $loginMethod
     */
    public function setLoginMethod($loginMethod)
    {
        $this->loginMethod = $loginMethod;
    }

    /**
     * @return null
     */
    public function getLoginResponse()
    {
        return $this->loginResponse;
    }

    /**
     * @param null $loginResponse
     */
    public function setLoginResponse($loginResponse)
    {
        $this->loginResponse = $loginResponse;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return float
     */
    public function getConnectionTimeout()
    {
        return $this->connectionTimeout;
    }

    /**
     * @param float $connectionTimeout
     */
    public function setConnectionTimeout($connectionTimeout)
    {
        $this->connectionTimeout = $connectionTimeout;
    }

    /**
     * @return float
     */
    public function getReadWriteTimeout()
    {
        return $this->readWriteTimeout;
    }

    /**
     * @param float $readWriteTimeout
     */
    public function setReadWriteTimeout($readWriteTimeout)
    {
        $this->readWriteTimeout = $readWriteTimeout;
    }

    /**
     * @return null
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param null $context
     */
    public function setContext($context)
    {
        $this->context = $context;
    }

    /**
     * @return null
     */
    public function getKeepalive()
    {
        return $this->keepalive;
    }

    /**
     * @param null $keepalive
     */
    public function setKeepalive($keepalive)
    {
        $this->keepalive = $keepalive;
    }

    /**
     * @return int
     */
    public function getHeartbeat()
    {
        return $this->heartbeat;
    }

    /**
     * @param int $heartbeat
     */
    public function setHeartbeat($heartbeat)
    {
        $this->heartbeat = $heartbeat;
    }

    /**
     * @return float
     */
    public function getChannelRpcTimeout()
    {
        return $this->channelRpcTimeout;
    }

    /**
     * @param float $channelRpcTimeout
     */
    public function setChannelRpcTimeout($channelRpcTimeout)
    {
        $this->channelRpcTimeout = $channelRpcTimeout;
    }
}