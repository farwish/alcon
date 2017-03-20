<?php

namespace Alcon\Services\Server;

/**
 * Swoole TCP/UDP Server.
 *
 * <code>
 *  // change it by yourself.
 *  new SwooleServer($ip, $port, $mode, $sock_type);
 *
 *  // access by swoole_client.
 * </code>
 *
 * @farwish
 */
class SwooleServer
{
    private $serv;

    private $on = [
        'connect',
        'receive',
        'close',  
    ];

    public function __construct($ip = '127.0.0.1', $port = 9501, $mode = SWOOLE_PROCESS, $sock_type = SWOOLE_SOCK_TCP)
    {
        $this->serv = new \swoole_server($ip, $port, $mode, $sock_type);    

        foreach ($this->on as $func) {
            $callback = 'on' . ucfirst($func);
            $this->serv->on($func, [$this, $callback]);
        }

        $this->serv->start();
    }

    public function onConnect($serv, $fd)
    {
        echo "Server: Client connected.\n";
    }

    public function onReceive($serv, $fd, $from_id, $data)
    {
        echo "Receive client data: {$data}\n";

        // Send data to this client.
        $serv->send($fd, "Server: " . mt_rand());

        // Close this client or not.
        $serv->close($fd);
    }

    public function onClose($serv, $fd)
    {
        echo "Server: Client [{$fd}] closed.\n";
    }
}
