<?php

namespace Alcon\Supports;

/**
 * 状态基类.
 *
 * @farwish
 */
abstract class STBase
{
	protected static $val = [];

    /** 
     * 获取.
     *
     * @return string | array
     */
    public static function get($key = null)
    {   
        return (isset($key) && isset(static::$val[$key])) ? static::$val[$key] : '';
    }   
}
