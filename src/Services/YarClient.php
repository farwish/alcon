<?php

namespace Alcon\Services;

/**
 * Service Yar Client.
 *
 * Doc: https://github.com/laruence/yar
 *
 * @farwish
 */
class YarClient
{
    /**
     * Service url.
     */
    public static $serv = null;

    /**
     * Instance.
     */
    public static $instance = null;

    /**
     * Synchronous call.
     */
    public static $sync = null;

    /**
     * Get instance.
     *
     * @param string $serv 服务地址.
     *
     * @return object | string
     *
     * @farwish
     */
    public static function get($serv = '')
    {
        if ( is_null(static::$serv) || static::$serv !== $serv || is_null(static::$sync) ) {
            static::$serv = $serv;
            static::$sync = true;
            static::$instance = new \Yar_Client($serv); 
        }

        return static::$instance;
    }

    /**
     * Concurrent client.
     *
     * @farwish
     */
    public static function cget($method, $parameters = [], $serv = '')
    {
        \Yar_Concurrent_Client::call($serv, $method, $parameters); 
    }

    /**
     * Concurrent call Send the Request.
     *
     * @farwish
     */
    public static function cloop()
    {
        \Yar_Concurrent_Client::loop();
    }
}
