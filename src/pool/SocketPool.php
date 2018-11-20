<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/20
 * Time: 13:55
 */

namespace rabbit\socket\pool;


use rabbit\pool\ConnectionPool;
use rabbit\socket\SocketClient;

/**
 * Class SocketPool
 * @package rabbit\socket\pool
 */
class SocketPool extends ConnectionPool
{
    /**
     * @return ConnectionInterface
     */
    public function createConnection(): ConnectionInterface
    {
        return new SocketClient($this);
    }
}