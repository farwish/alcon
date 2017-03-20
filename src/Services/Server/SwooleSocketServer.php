<?php

namespace Alcon\Services\Server;

/**
 * Service Swoole pure Websocket Server.
 * Without http server.
 *
 * <code>
 *  // change class by yourself.
 *  // `kill -15 pid` if daemon.
 *  $serv = new SwooleSocketServer();
 * </code>
 *
 * @farwish
 */
class SwooleSocketServer
{
    private $serv;

    private $on = [ 
        'open',
        'message',
        'close',
    ];  

    public function __construct($ip = '127.0.0.1', $port = 9501, $setting = []) 
    {   
        $this->serv = new \swoole_websocket_server($ip, $port);

        foreach ($this->on as $func) {
            $callback = 'on' . ucfirst($func);
            $this->serv->on($func, [$this, $callback]);
        }

        $this->serv->start();
    }   

    public function onOpen(\swoole_websocket_server $server, $request)
    {   
    }   

    public function onMessage(\swoole_websocket_server $server, $frame)
    {
    }

    public function onClose(\swoole_websocket_server $server, $fd)
    {
        echo __METHOD__ . " called.\n";
    }
}
