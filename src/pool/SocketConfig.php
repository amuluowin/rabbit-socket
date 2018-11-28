<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/20
 * Time: 13:40
 */

namespace rabbit\socket\pool;

use rabbit\pool\PoolProperties;

/**
 * Class SocketConfig
 * @package rabbit\socket\pool
 */
class SocketConfig extends PoolProperties
{
    /** @var int */
    private $domain = AF_INET;
    /** @var int */
    private $type = SOCK_STREAM;
    /** @var int */
    private $protocol = 0;
    /** @var string */
    private $bind = null;

    /**
     * @return int
     */
    public function getDomin(): int
    {
        return $this->domain;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getProtocol(): int
    {
        return $this->protocol;
    }

    /**
     * @return string
     */
    public function getBind(): ?string
    {
        return $this->bind;
    }
}