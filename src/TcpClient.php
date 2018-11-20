<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/22
 * Time: 18:13
 */

namespace rabbit\socket;

use rabbit\core\Exception;
use rabbit\socket\tcp\AbstracetTcpConnection;
use Swoole\Coroutine\Client;

/**
 * Class TcpClient
 * @package rabbit\socket
 */
class TcpClient extends AbstracetTcpConnection
{
    /**
     * @throws Exception
     */
    public function createConnection(): void
    {
        $client = new Client(SWOOLE_SOCK_TCP | SWOOLE_KEEP);

        $address = $this->pool->getConnectionAddress();
        $timeout = $this->pool->getTimeout();
        $setting = $this->pool->getPoolConfig()->getSetting();
        $setting && $client->set($setting);

        list($host, $port) = explode(':', $address);
        if (!$client->connect($host, $port, $timeout)) {
            $error = sprintf('Service connect fail error=%s host=%s port=%s', socket_strerror($client->errCode), $host, $port);
            throw new Exception($error);
        }
        $this->connection = $client;
    }

}