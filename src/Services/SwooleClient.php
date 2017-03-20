<?php

namespace Alcon\Services;

/**
 * Service Swoole Client.
 *
 * Doc: https://wiki.swoole.com/wiki/page/p-client.html
 *
 * <code>
 *  // change class by yourself.
 *  $cli = new SwooleClient($ip, $port);
 * </code>
 *
 * @farwish
 */
class SwooleClient
{
    private $client;

    private $on = [
        'connect',
        'receive',
        'error',
        'close',
    ];

    public function __construct($ip = '127.0.0.1', $port = 9501)
    {
        $this->client = new \swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);

        foreach ($this->on as $func) {
            $callback = 'on' . ucfirst($func);
            $this->client->on($func, [$this, $callback]);
        }

        $this->client->connect($ip, $port);
    }

    public function onConnect(\swoole_client $cli)
    {
    }

    public function onReceive(\swoole_client $cli, $data)
    {
    }

    public function onError(\swoole_client $cli)
    {
        echo __METHOD__ . " called.\n";
    }

    public function onClose(\swoole_client $cli)
    {
    }
}
