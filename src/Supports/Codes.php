<?php

namespace Alcon\Supports;

/**
 * 通用状态码.
 *
 * <code>
 *  $st = Codes::ACTION_SUC;
 *  $ms = Codes::get($st);
 * </code>
 *
 * @farwish
 */
class Codes extends STBase
{
    const ACTION_SUC = 0;
    const ACTION_FAL = -1;
    const ACTION_ILL = -2;
    const NO_SIGNIN  = -3;

    const INSERT_ERR = 1001;
    const UPDATE_ERR = 1002;
    const DELETE_ERR = 1003;
    const PARAM_ERR  = 1004;

    protected static $val = [
        self::ACTION_SUC => '操作成功',
        self::ACTION_FAL => '操作失败',
        self::ACTION_ILL => '非法操作',
        self::NO_SIGNIN  => '未登陆',

        self::INSERT_ERR => '添加失败',
        self::UPDATE_ERR => '更新失败',
        self::DELETE_ERR => '删除失败',
        self::PARAM_ERR  => '参数错误',
    ];
}
