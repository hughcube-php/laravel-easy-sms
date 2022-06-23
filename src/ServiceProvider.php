<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2021/4/18
 * Time: 10:32 下午.
 */

namespace HughCube\Laravel\EasySms;

use Overtrue\EasySms\EasySms as EasySmsSdk;

class ServiceProvider extends \HughCube\Laravel\ServiceSupport\ServiceProvider
{
    protected function getPackageFacadeAccessor(): string
    {
        return EasySms::getFacadeAccessor();
    }

    protected function createPackageFacadeRoot($app): EasySmsSdk
    {
        $config = $app->make('config')->get($this->getPackageFacadeAccessor(), []);
        return new EasySmsSdk($config);
    }
}
