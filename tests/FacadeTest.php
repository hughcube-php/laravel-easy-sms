<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2021/4/20
 * Time: 11:45 下午.
 */

namespace HughCube\Laravel\EasySms\Tests;

use HughCube\Laravel\EasySms\EasySms;
use Overtrue\EasySms\EasySms as EasySmsSdk;

class FacadeTest extends TestCase
{
    public function testIsFacade()
    {
        $this->assertInstanceOf(EasySmsSdk::class, EasySms::getFacadeRoot());
    }

    public function testGetConfig()
    {
        $this->assertInstanceOf(\Overtrue\EasySms\Support\Config::class, EasySms::getConfig());
    }
}
