<?php

namespace Alcon\Services\Server;

/**
 * Swoole Http Server.
 *
 * <code>
 *  // change it by yourself.
 *  new SwooleHttpServer($ip, $port);
 *
 *  // access in browser.
 * </code>
 *
 * @farwish
 */
class SwooleHttpServer
{
    private $serv;

    private $on = [
        'request',
    ];

    public function __construct($ip = '127.0.0.1', $port = 9501)
    {
        $this->serv = new \swoole_http_server($ip, $port);    

        foreach ($this->on as $func) {
            $callback = 'on' . ucfirst($func);
            $this->serv->on($func, [$this, $callback]);
        }

        $this->serv->start();
    }

    public function onRequest($request, $response)
    {
        $response->end("<h1>Hello</h1>");
    }
}
