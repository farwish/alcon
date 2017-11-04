<?php

namespace Alcon\Thirdparty\Wechat;

/**
 * abstract class.
 *
 * @author farwish
 */
Abstract class WxAbstract
{
    /**
     * @var string
     */
    protected static $appid;

    /**
     * @var string
     */
    protected static $secret;

    /**
     * init.
     *
     * @param array $options
     * [
     *  'appid' => '',
     *  'secret' => '',
     * ]
     *
     * <code>
     *  Wx::init([ $appid, $secret ]);
     * </code>
     *
     */
    private static function init(array $options)
    {
        $opt = reset($options);
        static::$appid = $opt[0];
        static::$secret = $opt[1];
    }

    /**
     * 发送post请求
     * @param string $url
     * @param string $param
     * @return bool|mixed
     */
    public static  function parsePostJson($url = '', $param = '')
    {
        if (empty($url) || empty($param)) {
            return false;
        }
        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init(); //初始化curl
        curl_setopt($ch, CURLOPT_URL, $postUrl); //抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0); //设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1); //post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch); //运行curl
        curl_close($ch);
        return json_decode($data, TRUE);
    }

    /**
     * 获取数据(可重写).
     *
     * @param string $url
     *
     * @access protected
     *
     * @return string
     */
    public static function got($url)
    {
        return file_get_contents($url);
    }

    /**
     * 解析数据.
     *
     * @param string $url
     *
     * @access protected
     *
     * @return string
     */
    public static function parseJson($url)
    {
        return json_decode(static::got($url), TRUE);
    }

    public static function __callStatic($method, $arguments)
    {
        static::$method($arguments);
    }
}
