<?php

namespace Alcon\Tests\Supports;

use PHPUnit\Framework\TestCase;
use Alcon\Supports\Codes;

/**
 * phpunit --bootstrap ../autoload.php Supports/CodesTest
 *
 * Class CodesTest
 * @package Alcon\Tests\Supports
 */
class CodesTest extends TestCase
{
    private $key = 'ACTION_SUC';
    private $val = '操作成功';

    public function testGet()
    {
        $msg = Codes::get(Codes::ACTION_SUC);

        $this->assertEquals($msg, $this->val);
    }

    public function testMap()
    {
        $msg = Codes::map($this->key);

        $this->assertEquals($msg, $this->val);
    }
}