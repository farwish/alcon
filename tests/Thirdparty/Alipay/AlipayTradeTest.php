<?php

namespace Alcon\Tests\Thirdparty\Alipay;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;
use Alcon\Thirdparty\Alipay\AlipayTrade;

/**
 * In tests/ directory, run:
 *  phpunit --bootstrap ../../../../vendor/autoload.php Thirdparty/Alipay/AlipayTradeTest
 *
 * Or in alcon/ directory, run
 *  phpunit
 *
 * @license Apache-2.0
 * @author farwish farwish@foxmail.com
 */
class AlipayTradeTest extends TestCase
{
    /* @var AlipayTrade */
    protected $alipay_trade;

    public function setUp()
    {
        $this->alipay_trade = new AlipayTrade();

        // Load alipay config columns

        if (! file_exists(__DIR__ . '/.env')) {
            copy(__DIR__ . '/.env.dist', __DIR__ . '/.env');
            die("\n\033[31m" . __CLASS__ . " need you edit config file " . __DIR__ . "/.env at first!\033[0m\n");
        }
        (new Dotenv())->load(__DIR__ . '/.env');
    }

    public function initAlipay()
    {
        $this->alipay_trade->setPid( $_ENV['alipay_pid'] );
        $this->alipay_trade->setAppid( $_ENV['alipay_appid'] );
        $this->alipay_trade->setAlipayPublicKeyPath( $_ENV['alipay_public_key_path'] );
        $this->alipay_trade->setAlipayAppPrivateKeyPath( $_ENV['alipay_app_private_key_path'] );
        $this->alipay_trade->setNotifyUrl( $_ENV['alipay_notify_url'] );
    }

    /**
     * 当面付扫码付下单预创建测试
     *
     * 预创建返回结果：
     *
     * 异常>
     * array (1)
     *   · [alipay_trade_precreate_response]: array (4)
     *   ·  · [code]: string (5) "40001"
     *   ·  · [msg]: string (26) "Missing Required Arguments"
     *   ·  · [sub_code]: string (18) "isv.missing-app-id"
     *   ·  · [sub_msg]: string (9) "缺少AppID参数"
     *
     * 成功>
     *   array (2)
     *   · [alipay_trade_precreate_response]: array (4)
     *   ·  · [code]: string (5) "10000"
     *   ·  · [msg]: string (7) "Success"
     *   ·  · [out_trade_no]: string (28) "201999999999999999999999999"
     *   ·  · [qr_code]: string (46) "https://qr.alipay.com/aaaaaaaaaaaaaaaaaaaaa"
     *   · [sign]: string (172) "xxxxxxxxxxxxxxxxxx"
     */
    public function testPrecreate()
    {
        $this->initAlipay();
        $this->alipay_trade->precreateSet('0.01', '15m', '测试单', '订单在15分钟内有效,请尽快支付');

        $json = $this->alipay_trade->precreate();

        echo "\n{$json}\n";

        $this->assertContains('alipay_trade_precreate_response', $json);
    }

    /**
     * 退款测试
     *
     * 退款返回结果：
     *  array (2)
     *   · [alipay_trade_refund_response]: array (11)
     *   ·  · [code]: string (5) "10000"
     *   ·  · [msg]: string (7) "Success"
     *   ·  · [buyer_logon_id]: string (13) "916***@qq.com"
     *   ·  · [buyer_user_id]: string (16) "xxxxxxxxxxxxxx"
     *   ·  · [fund_change]: string (1) "Y"
     *   ·  · [gmt_refund_pay]: string (19) "xxxx-xx-xx 00:00:00"
     *   ·  · [out_trade_no]: string (28) "201999999999999999999999999"
     *   ·  · [refund_detail_item_list]: array (1)
     *   ·  ·  · [0]: array (2)
     *   ·  ·  ·  · [amount]: string (4) "0.01"
     *   ·  ·  ·  · [fund_channel]: string (13) "ALIPAYACCOUNT"
     *   ·  · [refund_fee]: string (4) "0.01"
     *   ·  · [send_back_fee]: string (4) "0.01"
     *   ·  · [trade_no]: string (28) "201888888888888888888888888"
     *   · [sign]: string (172) "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
     */
    public function testRefund()
    {
        $this->initAlipay();
        $this->alipay_trade->refundSet('201999999999999999999999999', '0.01');

        $json = $this->alipay_trade->refund();

        echo "\n{$json}\n";

        $this->assertContains('alipay_trade_refund_response', $json);
    }
}
