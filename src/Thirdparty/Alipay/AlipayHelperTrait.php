<?php

namespace Alcon\Thirdparty\Alipay;

/**
 * alipay core util function.
 *
 * 含初始化参数及签名方法
 *
 * @license Apache-2.0
 * @author farwish farwish@foxmail.com
 */
trait AlipayHelperTrait
{
    /**
     * 商户UID
     *
     * @var int
     */
    protected $pid;

    /**
     * 应用APPID
     *
     * @var int
     */
    protected $appid;

    /**
     * 支付网关
     *
     * @var string
     */
    protected $gateway = 'https://openapi.alipay.com/gateway.do';

    /**
     * 回调地址
     *
     * @var string
     */
    protected $notify_url;

    /**
     * 支付宝公钥绝对路径(首选)
     *
     * @var string
     */
    protected $alipay_public_key_path;

    /**
     * 应用私钥绝对路径(首选)
     *
     * @var string
     */
    protected $alipay_app_private_key_path;

    /**
     * 支付宝公钥值(次选)
     *
     * @var string
     */
    protected $alipay_public_key;

    /**
     * 应用私钥值(次选)
     *
     * @var string
     */
    protected $alipay_app_private_key;

    /**
     * 设置商户UID
     *
     * @param string $pid 商户UID
     */
    public function setPid($pid)
    {
        $this->pid = $pid;
    }

    public function getPid()
    {
        return $this->pid;
    }

    /**
     * 设置APPID
     *
     * @param string $appid APPID
     */
    public function setAppid($appid)
    {
        $this->appid = $appid;
    }

    public function getAppid()
    {
        return $this->appid;
    }

    /**
     * 设置网关
     *
     * @param string $gateway 支付宝网关
     */
    public function setGateway($gateway)
    {
        $this->gateway = $gateway;
    }

    public function getGateway()
    {
        return $this->gateway;
    }

    /**
     * 设置回调地址
     *
     * @param string $notify_url
     */
    public function setNotifyUrl(string $notify_url)
    {
        $this->notify_url = $notify_url;
    }

    public function getNotifyUrl()
    {
        return $this->notify_url;
    }

    /**
     * 设置支付宝公钥绝对路径
     *
     * @param string $alipay_public_key_path
     */
    public function setAlipayPublicKeyPath(string $alipay_public_key_path)
    {
        $this->alipay_public_key_path = $alipay_public_key_path;
    }

    public function getAlipayPublicKeyPath()
    {
        return $this->alipay_public_key_path;
    }

    /**
     * 设置应用私钥绝对路径
     *
     * @param string $alipay_app_private_key_path
     */
    public function setAlipayAppPrivateKeyPath(string $alipay_app_private_key_path)
    {
        $this->alipay_app_private_key_path = $alipay_app_private_key_path;
    }

    public function getAlipayAppPrivateKeyPath()
    {
        return $this->alipay_app_private_key_path;
    }

    /**
     * 设置支付宝公钥值
     *
     * @param string $alipay_public_key
     */
    public function setAlipayPublicKey(string $alipay_public_key)
    {
        $this->alipay_public_key = $alipay_public_key;
    }

    public function getAlipayPublicKey()
    {
        return $this->alipay_public_key;
    }

    /**
     * 设置应用私钥值
     *
     * @param string $alipay_app_private_key
     */
    public function setAlipayAppPrivateKey(string $alipay_app_private_key)
    {
        $this->alipay_app_private_key = $alipay_app_private_key;
    }

    public function getAlipayAppPrivateKey()
    {
        return $this->alipay_app_private_key;
    }

    /**
     * 应用最终使用的用来获得 sign 的方法
     *
     * @param array $params_wait_to_sign
     *
     * @return string
     */
    protected function generateSign(array $params_wait_to_sign)
    {
        // 1.
        $sorted = [];
        foreach ($params_wait_to_sign as $key => $item) {
            if (! empty($item)) {
                $sorted[$key] = $item;
            }
        }
        ksort($sorted);

        // 2.
        $decoded_query_string = urldecode(http_build_query($sorted));

        // 3.
        $sign = self::signature($decoded_query_string);

        return $sign;
    }

    /**
     * 仅对字符串签名(SHA1 / sha1withRSA)
     *
     * 应用中应该使用的是 generateSign 方法
     *
     * <code>
     * $string_wait_to_sign = urldecode(http_build_query($sorted_array));
     * $sign = self::signature($string_wait_to_sign);
     * </code>
     *
     * @param string $encoded_query_string 待签名的字符串
     *
     * @return string
     */
    protected function signature(string $decoded_query_string)
    {
        // 优先使用私钥路径，否则取私钥值
        if ($this->alipay_app_private_key_path) {
            $private_key = file_get_contents( $this->alipay_app_private_key_path );
        } else {
            $private_key =
                "-----BEGIN RSA PRIVATE KEY-----\n" .
                $this->alipay_app_private_key .
                "\n-----END RSA PRIVATE KEY-----";
        }

        $resource = openssl_get_privatekey($private_key);

        openssl_sign($decoded_query_string, $signature, $resource);

        $signature = base64_encode($signature);

        return $signature;
    }
}
