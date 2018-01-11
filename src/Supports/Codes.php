<?php

namespace Alcon\Supports;

/**
 * 通用状态码.
 *
 * <code>
 *  $status = Codes::ACTION_SUC;
 *  $msg_get = Codes::get($status);      // output: 操作成功
 *  $msg_map = Codes::map('ACTION_SUC'); // output: 操作成功
 * </code>
 *
 * @license Apache-2.0
 * @author farwish farwish@foxmail.com
 */
class Codes
{
    use \Alcon\Supports\StatusTrait;

    const ACTION_SUC = 0;
    const ACTION_FAL = -1;
    const ACTION_ILL = -2;
    const NO_SIGNIN  = -3;

    const INSERT_ERR = 1001;
    const UPDATE_ERR = 1002;
    const DELETE_ERR = 1003;
    const PARAM_ERR  = 1004;

    // key value map, easy extend.
    const _LIST = [
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
