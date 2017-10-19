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

        $this->assertContains('百度', Helper::sendRequest($url, $options));
    }

    public function testMultiProcess()
    {
        // 初始数据
        $data = [1, 2, 3, 4, 5, 6, 7];

        // 每组数据量
        $chunk_size = 5;

        $groups = array_chunk($data, $chunk_size);

        $worker_num = count($groups);

        $terminated = Helper::multiProcess($worker_num, $groups, function($current_group, $worker_no) {
            // job...
            echo PHP_EOL . "Worker {$worker_no} ran" . PHP_EOL;
        });

        $this->assertEquals($terminated, $worker_num);
    }

    public function testCommonConvertEncode()
    {
        $string = '3系';

        $encoded = Helper::commonConvertEncode($string);

        $this->assertEquals($string, $encoded);
    }
}
