<?php

namespace Alcon\Supports;

/**
 * 状态辅助函数.
 *
 * @farwish
 */
trait StatusTrait
{
    /**
     * Get value.
     *
     * @param int $code
     *
     * @return int
     */
    public static function get(int $code)
    {
        return self::_LIST[$code] ?? 0;
    }

    /**
     * Get Content.
     *
     * @param string $key
     *
     * @return string
     */
    public static function map(string $key = '')
    {
        $ref = new \ReflectionClass(static::class);

        $value = $ref->getConstant($key);

        return $ref->getConstant('_LIST')[$value] ?? '';
    }
}
