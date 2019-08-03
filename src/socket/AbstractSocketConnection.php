<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/20
 * Time: 11:51
 */

namespace rabbit\socket\socket;

use rabbit\core\Exception;
use rabbit\pool\AbstractConnection;


/**
 * Class AbstracetSocketConnection
 * @package rabbit\socket\socket
 */
abstract class AbstractSocketConnection extends AbstractConnection implements SocketClientInterface
{
    protected $connection;

    /**
     * @param string $data
     * @param float $timeout
     * @return int
     */
    public function send(string $data, float $timeout = -1): int
    {
        $ln = strlen($data);
        while ($data && $ln > 0) {
            $result = $this->connection->sendAll($data, $timeout);
            if ($result !== false && $result > 0) {
                $data = substr($data, $result);
            }
        }
        $this->recv = false;
        return $ln;
    }

    /**
     * @param float $timeout
     * @return mixed|void
     */
    public function receive(float $timeout = -1)
    {
        throw new \BadMethodCallException('can not call function ' . __METHOD__);
    }

    /**
     * @param int $length
     * @param float $timeout
     * @return string
     * @throws Exception
     */
    public function recv(int $length = 65535, float $timeout = -1): string
    {
        $data = $this->connection->recvAll($length, $timeout);
        return $data;
    }

    /**
     * @param string $address
     * @param int $port
     * @return bool
     */
    public function bind(string $address, int $port = 0): bool
    {
        return $this->connection->bind($address, $port);
    }

    /**
     * @param int $backlog
     * @return bool
     */
    public function listen(int $backlog = 0): bool
    {
        return $this->connection->listen($backlog);
    }

    /**
     * @param float $timeout
     * @return null|Coroutine\Socket
     */
    public function accept(float $timeout = -1): ?\Swoole\Coroutine\Socket
    {
        $this->connection->accept($timeout);
    }

    /**
     * @param string $address
     * @param int $port
     * @param string $data
     * @return int|null
     */
    public function sendto(string $address, int $port, string $data): ?int
    {
        $client = $this->connection->sendto($address, $port, $data);
        if ($client === false) {
            return null;
        }
        return $client;
    }

    /**
     * @param array $peer
     * @param float $timeout
     * @return null|string
     */
    public function recvfrom(array &$peer, float $timeout = -1): ?string
    {
        $data = $this->connection->recvfrom($peer, $timeout);
        if ($data === false) {
            return null;
        }
        return $data;
    }

    /**
     * @return array
     */
    public function getsockname(): array
    {
        return $this->connection->getsockname();
    }

    /**
     * @return array
     */
    public function getpeername(): array
    {
        return $this->connection->getpeername();
    }

    /**
     * @return bool
     */
    public function check(): bool
    {
        return true;
    }

    /**
     * @throws Exception
     */
    public function reconnect(): void
    {
        $this->createConnection();
    }

    /**
     * @return bool
     */
    public function close(): bool
    {
        return $this->connection->close();
    }
}