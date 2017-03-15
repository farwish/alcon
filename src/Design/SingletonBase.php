<?php

namespace Alcon\Design;

/**
 * Singleton Design for instance,
 *  instead of 'new' and save little memory.
 *
 * <code>
 *  class Demo {
 *      use SingletonBase;
 *
 *      public function dosome() {}
 *  }
 *  $demo = Demo::getInstance();
 *  $demo->dosome();
 * </code>
 *
 * @farwish
 */
trait SingletonBase
{
    /** 
     * Current object.
     *
     * @var object
     */
    private static $instance = null;

    /** 
     * Get instance.
     *
     * @return object
     */
    public static function getInstance()
    {   
        if ( is_null(static::$instance) ) { 
            static::$instance = new self();
        }

        return static::$instance;
    }   
}
