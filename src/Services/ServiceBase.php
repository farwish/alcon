<?php

namespace YkCommon\Services;

class ServiceBase
{
    public static $instance = null;

    /**
     * Get instance.
     *
     * @param string $serv 服务地址.
     *
     * @return object | string
     *
     * @farwish
     */
    public static function got($serv)
    {
        if ( is_null(static::$instance) ) {
            static::$instance = new \Yar_Client($serv); 
        }
        return static::$instance;
    }
}
