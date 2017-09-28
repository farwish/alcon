<?php

namespace Alcon\Tests\Supports;

use PHPUnit\Framework\TestCase;
use Alcon\Supports\Helper;

class HelperTest extends TestCase
{
    public function testGetSign()
    {
        $key = 'b9514c52-5363-4364-b73f-a2ec93ae6b34';
        $url = "b=v1&a=v2&c=v3";

        $client_sign = Helper::getSign($url, $key, true);

        $request_url = $url . "&sign={$client_sign}";

        $server_sign = Helper::getSign($request_url, $key, false);

        $this->assertEquals($client_sign, $server_sign);
    }

    public function testSendRequest()
    {
        $url = 'https://www.baidu.com';

        $options = [ 
            'http' => [
                'method' => 'GET',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content'=> '', 
            ],
        ];

        $this->assertContains('百度', Helper::send_request($url, $options));
    }
}
