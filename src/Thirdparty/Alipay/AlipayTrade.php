<?php

namespace Alcon\Thirdparty\Alipay;

use GuzzleHttp\Client;

/**
 * alipay core trade function.
 *
 * 用法参考 tests/Thirdparty/Alipay/AlipayTradeTest.php.
 *
 * @license Apache-2.0
 * @author farwish <farwish@foxmail.com>
 */
class AlipayTrade
{
    use \Alcon\Thirdparty\Alipay\AlipayHelperTrait;

    /**
     * 支付公共请求参数
     *
     * @var array
     */
    public $commonParams;

    /**
     * 支付请求参数
     *
     * @var array
     */
    public $requestParams;

    /**
     * 退款请求参数
     *
     * @var array
     */
    public $refundRequestParams;

    /**
     * AlipayTrade constructor.
     */
    public function __construct()
    {
        self::initCommonParams();
        self::initRequestParams();
        self::initRefundRequestParams();
    }

    public function initCommonParams()
    {
        $this->commonParams = [
            'app_id'        => '',
            'method'        => '',
            'format'        => 'JSON',      // 可选
            'charset'       => 'utf-8',
            'sign_type'     => 'RSA',
            'sign'          => '',
            'timestamp'     => '',
            'version'       => '1.0',
            'notify_url'    => '',          // 可选
            'app_auth_token'=> '',          // 可选
            'biz_content'   => '',          // 除公共参数外的所有请求参数json集合
        ];
    }

    public function initRequestParams()
    {
        $this->requestParams = [
            'out_trade_no'          => '',
            'seller_id'             => '',  // 可选
            'total_amount'          => '',
            'discountable_amount'   => '',  // 可选
            'subject'               => '',
            'goods_detail'          => '',  // 可选
            'body'                  => '',  // 可选
            'operator_id'           => '',  // 可选
            'store_id'              => '',  // 可选
            'disable_pay_channels'  => '',  // 可选
            'enable_pay_channels'   => '',  // 可选
            'terminal_id'           => '',  // 可选
            'extend_params'         => '',  // 可选
            'timeout_express'       => '',  // 可选
            'business_params'       => '',  // 可选
        ];
    }

    public function initRefundRequestParams()
    {
        $this->refundRequestParams = [
            'out_trade_no'   => '',     // 特殊可选，商户订单号，不能与 trade_no 同时为空
            'trade_no'       => '',     // 特殊可选，支付宝交易号，和商户订单号不能同时为空
            'refund_amount'  => '',
            'refund_reason'  => '',     // 可选
            'out_request_no' => '',     // 可选
            'operator_id'    => '',     // 可选
            'store_id'       => '',     // 可选
            'terminal_id'    => '',     // 可选
        ];
    }

    /**
     * 用默认方式设置公共参数和请求参数的方法
     *
     * 如需自定义可使用 precreateSetCustom
     *
     * @param string $total_amount   总金额
     * @param string $timeout        订单支付超时时间
     * @param string $subject        标题
     * @param string $body           提示
     * @param array  &$requestParams 外部需要使用订单参数的时候设置
     *
     * @return void
     */
    public function precreateSet($total_amount, $timeout, $subject, $body, &$requestParams = null)
    {
        $this->commonParams['app_id']       = $this->appid;
        $this->commonParams['method']       = 'alipay.trade.precreate';
        $this->commonParams['timestamp']    = date('Y-m-d H:i:s');
        $this->commonParams['notify_url']   = $this->notify_url;

        $micro_time = explode(' ', microtime());

        // 28位
        $this->requestParams['out_trade_no']    = date('YmdHis')
                                                    . str_pad(ltrim($micro_time[0], '0.'), 10, 6)
                                                    . mt_rand(1000, 9999);
        $this->requestParams['total_amount']    = $total_amount;
        $this->requestParams['timeout_express'] = $timeout;
        $this->requestParams['subject']         = $subject;
        $this->requestParams['body']            = $body;

        $requestParams = $this->requestParams;
    }

    /**
     * 设置公共参数和请求参数的方法，自由度高
     *
     * 一般调用 precreateSet/refundSet 即可，除了想定义传参的情况
     *
     * <code>
     *   $this->alipay_trade = new AlipayTrade();
     *   $this->alipay_trade->setPid('xx');
     *   ...
     *   $this->alipay_trade->precreateSet('0.01', '15m', '测试单', '订单在15分钟内有效,请尽快支付');
     *
     *   以上相当于下面的代码：
     *
     *   $this->alipay_trade->preSetCustom(
     *       function() {
     *           $this->alipay_trade->commonParams['app_id']       = $this->alipay_trade->getAppid();
     *           $this->alipay_trade->commonParams['method']       = 'alipay.trade.precreate';
     *           $this->alipay_trade->commonParams['timestamp']    = date('Y-m-d H:i:s');
     *           $this->alipay_trade->commonParams['notify_url']   = $this->alipay_trade->getNotifyUrl();
     *
     *           $micro_time = explode(' ', microtime());
     *
     *           // 28位
     *           $this->alipay_trade->requestParams['out_trade_no']    = date('YmdHis')
     *                                                                   . str_pad(ltrim($micro_time[0], '0.'), 10, 6)
     *                                                                   . mt_rand(1000, 9999);
     *           $this->alipay_trade->requestParams['total_amount']    = '0.01';
     *           $this->alipay_trade->requestParams['timeout_express'] = '15m';
     *           $this->alipay_trade->requestParams['subject']         = '测试单';
     *           $this->alipay_trade->requestParams['body']            = '订单在15分钟内有效,请尽快支付';
     *       }
     *   );
     * </code>
     *
     * @param \Closure|null $closure 一个无参数的匿名函数
     */
    public function preSetCustom(\Closure $closure = null)
    {
        if ( is_callable($closure) ) {
            $closure();
        }
    }

    /**
     * 调用支付宝接口，生成二维码后，展示给用户，由用户扫描二维码完成订单支付。
     *
     * alipay.trade.precreate(统一收单线下交易预创建)
     *
     * <code>
     *  $trade = new AlipayTrade();
     *  $trade->setPid('xx');
     *  $trade->setAppid('xx');
     *  $trade->setAlipayPublicKeyPath('xx');
     *  $trade->setAlipayAppPrivateKeyPath('xx');
     *  $trade->setNotifyUrl('http://xx');
     *  $trade->precreateSet('xx', 'xx', 'xx', 'xx');
     *  $trade->precreate();
     * </code>
     *
     * @param int $timeout
     *
     * @return mixed
     * @throws \Exception
     */
    public function precreate($timeout = 5)
    {
        try {
            self::filterEmptyParams($this->commonParams);
            self::filterEmptyParams($this->requestParams);

            $this->commonParams['biz_content'] = json_encode($this->requestParams);

            $this->commonParams['sign'] = self::generateSign($this->commonParams);

            /* @var Client $client */
            $client = new Client([
                'timeout' => $timeout,
            ]);

            $json = $client->request(
                'POST'
                ,$this->gateway
                ,['form_params' => $this->commonParams]
            )->getBody()->getContents();

            return $json;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 设置退款参数，默认
     *
     * 如需自定义，可使用 preSetCustom
     *
     * @param string $out_trade_no  商户订单号
     * @param float $refund_amount  退款金额
     *
     * @return void
     */
    public function refundSet($out_trade_no, $refund_amount)
    {
        unset($this->commonParams['notify_url']);

        $this->commonParams['app_id']     = $this->appid;
        $this->commonParams['method']     = 'alipay.trade.refund';
        $this->commonParams['timestamp']  = date('Y-m-d H:i:s');

        $micro_time = explode(' ', microtime());

        $this->refundRequestParams['out_trade_no']    = $out_trade_no;
        $this->refundRequestParams['refund_amount']   = $refund_amount;
        $this->refundRequestParams['out_request_no']  = $micro_time[1] . ltrim($micro_time[0], '0.');
    }

    /**
     * 退款
     *
     * alipay.trade.refund (统一收单交易退款接口)
     *
     * <code>
     *  $trade = new AlipayTrade();
     *  $trade->setPid('xx');
     *  $trade->setAppid('xx');
     *  $trade->setAlipayPublicKeyPath('xx');
     *  $trade->setAlipayAppPrivateKeyPath('xx');
     *  $trade->refundSet('xx', 'xx');
     *  $trade->refund();
     * </code>
     *
     * @param int $timeout
     *
     * @return array|bool|float|int|string
     * @throws \Exception
     */
    public function refund($timeout = 5)
    {
        try {
            self::filterEmptyParams($this->commonParams);
            self::filterEmptyParams($this->refundRequestParams);

            $this->commonParams['biz_content'] = json_encode($this->refundRequestParams);

            $this->commonParams['sign'] = self::generateSign($this->commonParams);

            /* @var Client $client */
            $client = new Client([
                'timeout' => $timeout,
            ]);

            $json = $client->request(
                'POST'
                ,$this->gateway
                ,['form_params' => $this->commonParams]
            )->getBody()->getContents();

            return $json;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 过滤传递的空参数
     *
     * @param &$params
     *
     * @return void
     */
    protected function filterEmptyParams(&$params)
    {
        foreach ($params as $key => $item) {
            if (empty($item)) {
                unset($params[$key]);
            }
        }
    }
}
